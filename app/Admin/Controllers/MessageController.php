<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\API\MessageController as ApiMessageController;
use App\Models\Message;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MessageController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Message';


    /**
     * Show received messages list by authorised user
     *
     * @param Content $content
     * @return Content
     */
    public function receivedMessages(Content $content)
    {
        $authorisedUserId = auth()->id();

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->getReceivedMessagesGrid($authorisedUserId));
    }

    /**
     * Show sent messages list by authorised user
     *
     * @param Content $content
     * @return Content
     */
    public function sentMessages(Content $content)
    {
        $authorisedUserId = auth()->id();

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->getSentMessagesGrid($authorisedUserId));
    }

    /**
     * Show a message form to the known user with known subject by default
     * (Option "write an answer" in received messages list)
     *
     * @param $id
     * @param Content $content
     * @return Content
     */
    public function writeAnswerMessage($id, Content $content)
    {
        $to = $id;
        $subject = request()->input('subject', '');
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->messageFormWithKnownRecepientAndSubject($to, $subject));
    }


    /**
     * Show a new message form to unknown user with unknown subject by default
     * (Button "New")
     *
     * @param Content $content
     * @return Content
     */
    public function writeNewMessage(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->messageForm());
    }

    /**
     * Responds to AJAX request from New Message Form When user write something in "To" field
     *
     * @return mixed
     */
    public function findUsersByEmail()
    {
        $q = request()->input('q', null);

        return User::where('email', 'like', "%$q%")->paginate(null, ['id', 'email as text']);
    }

    /**
     * Save sent message using other controller
     */
    public function saveMessage()
    {
        $controller = new ApiMessageController();

        $controller->store(request());
    }


    /**
     * Build received messages grid list by user
     *
     * @return Grid
     */
    protected function getReceivedMessagesGrid($id)
    {
        $grid = new Grid(new Message());
        $grid->model()->where('to_id', $id)->orderBy('created_at', 'DESC');

        $grid->column('from')->display(function () {
            return $this->from->name . ' ' . $this->from->surname;
        });

        $grid->column('subject', 'Subject')->modal('Message', function ($model) {
            $props = [
                'way' => 'From',
                'opponent' => $this->from->name . ' ' . $this->from->surname,
                'opponent_id' => $this->from->id,
                'subject' => $this->subject->id,
                'text' => $this->text,
            ];
            return view('admin.message', $props);
        });

        $grid->column('created_at', __('Created at'))->display(function () {
            return $this->created_at->format('Y-m-d h:i:s');
        });

        $grid->column('read', __('Read'))->bool();

        $grid->disableExport();
        $grid->disableTools();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Build received messages grid list by user
     *
     * @return Grid
     */
    protected function getSentMessagesGrid($id)
    {
        $grid = new Grid(new Message());
        $grid->model()->where('from_id', $id)->orderBy('created_at', 'DESC');

        $grid->column('to')->display(function () {
            return $this->to->name . ' ' . $this->to->surname;
        });

        $grid->column('subject', __('Subject'))->display(function () {
            return $this->subject;
        })->modal('Subject', function ($model) {
            $props = [
                'way' => 'To',
                'opponent' => $this->to->name . ' ' . $this->to->surname,
                'subject' => $this->subject->id,
                'text' => $this->text,
            ];
            return view('admin.message', $props);
        });

        $grid->column('created_at', __('Created at'))->display(function () {
            return $this->created_at->format('Y-m-d h:i:s');
        });

        $grid->column('read', __('Read'))->bool();

        $grid->disableExport();
        $grid->disableTools();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }


    /**
     * Built a new message form for action WriteNewMessage
     *
     * @return Form
     */
    protected function messageForm()
    {
        $form = new Form(new Message());

        $form->hidden('from_id', __('From id'))->default(auth()->id());

        $form->select('to_id', 'To')->options(function ($id) {
            $user = User::find($id);

            if ($user) {
                return [$user->id => $user->email];
            }
        })->ajax('/admin/find/users');

        $form->text('subject', __('Subject'));

        $form->textarea('text', __('Text'));

        $form->setAction(config('app.url') . '/admin/messages/sent');

        return $form;
    }

    /**
     * Built a new message form for action WriteAnswerMessage
     *
     * @return Form
     */
    protected function messageFormWithKnownRecepientAndSubject($to_id, $subject)
    {
        $form = new Form(new Message());

        $to_user = User::find($to_id);
        $to_name = $to_user->name . ' ' . $to_user->surname;

        $form->hidden('from_id', __('From id'))->default(auth()->id());
        $form->hidden('to_id', __('To id'))->default($to_id);
        $form->display('to')->default($to_name);
        $form->text('subject', __('Subject'))->default($subject);
        $form->textarea('text', __('Text'));

        $form->setAction(config('app.url') . '/admin/messages/sent');

        return $form;
    }


}
