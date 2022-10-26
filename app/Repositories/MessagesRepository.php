<?php

namespace App\Repositories;

use App\Models\Trip as Model;

class MessagesRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getUserDialoguesAboutOrders(int $userId)
    {
        $subjects = $this->startConditions()->select(['subject'])->where('from_id', $userId)->orWhere('to_id',
            $userId)->distinct()->get();

        $dialogues = $subjects->filter(function ($subject) use ($userId) {

            $orderUserID = app(OrdersRepository::class)->getUserIdOfOrderByOrderId($subject->subject);

            return $orderUserID === $userId;

        });

        return $dialogues;
    }

    public function getMessagesListAboutOrder(int $orderId)
    {
        $result = $this->startConditions()->with(['from', 'to'])->where('subject', $orderId)->get();

        return $result;
    }

    public function getMessageForDelete(int $messageId)
    {
        $result = $this->startConditions()->find($messageId);

        return $result;
    }

    public function getAllInboxMessagesOfUser(int $userId)
    {
        $messages = $this->startConditions()->with(['from', 'to'])->where('to_id', $userId)->get();

        return $messages;
    }

    public function getAllSentMessagesOfUser(int $userId)
    {
        $messages = $this->startConditions()->with(['from', 'to'])->where('from_id', $userId)->get();

        return $messages;
    }

    public function getUserDialogueWithOtherUser(int $userId, int $otherUserId)
    {
        $messages = $this->startConditions()->with(['from', 'to'])->where(function ($query) use (
            $userId,
            $otherUserId
        ) {
            $query->where('from_id', $userId)->where('to_id', $otherUserId);
        })->orWhere(function ($query) use ($userId, $otherUserId) {
            $query->where('from_id', $otherUserId)->where('to_id', $userId);
        })->orderBy('created_at', 'DESC')->get();

        return $messages;
    }

    public function checkIsFirstMessage(int $userId, int $otherUserId)
    {
        $numberOfMessages = $this->startConditions()->where('from_id', $userId)->where('to_id',
            $otherUserId)->get()->count('id');

        return $numberOfMessages === 1;
    }
}
