<?php

namespace App\Admin\Controllers;

use App\Models\Message;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Message';



    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Message::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('from_id', __('From id'));
        $show->field('to_id', __('To id'));
        $show->field('subject', __('Subject'));
        $show->field('text', __('Text'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('read', __('Read'));
        $show->field('noticed', __('Noticed'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Message());

        $form->number('from_id', __('From id'));
        $form->number('to_id', __('To id'));
        $form->text('subject', __('Subject'));
        $form->textarea('text', __('Text'));
        $form->switch('read', __('Read'));
        $form->switch('noticed', __('Noticed'));

        return $form;
    }

    public function received(Content $content) {
        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->receivedList());
    }

    public function sent(Content $content) {
        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->sentList());
    }


    protected function receivedList()
    {
        $grid = new Grid(new Message());
        $grid->model()->where('to_id', auth()->id());

        $grid->column('from')->display(function () {
            return $this->from->name . ' ' . $this->from->surname;
        });
        $grid->column('subject', __('Subject'))->modal('Message', function ($model) {
            $props = [
                'way' => 'From',
                'opponent' => $this->from->name . ' ' . $this->from->surname,
                'opponent_id' => $this->from->id,
                'subject' => $this->subject,
                'text' => $this->text,
            ];
            return view('admin.message', $props);
        });
        $grid->column('created_at', __('Created at'))->display(function () {
            return $this->created_at->format('Y-m-d h:i:s');
        });
        $grid->column('read', __('Read'))->bool();

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableTools();

        return $grid;
    }

    protected function sentList()
    {
        $grid = new Grid(new Message());
        $grid->model()->where('from_id', auth()->id());

        $grid->column('to')->display(function () {
            return $this->to->name . ' ' . $this->to->surname;
        });
        $grid->column('subject', __('Subject'))->modal('Message', function ($model) {
            $props = [
                'way' => 'To',
                'opponent' => $this->to->name . ' ' . $this->to->surname,
                'subject' => $this->subject,
                'text' => $this->text,
            ];
            return view('admin.message', $props);
        });
        $grid->column('created_at', __('Created at'))->display(function () {
            return $this->created_at->format('Y-m-d h:i:s');
        });
        $grid->column('read', __('Read'))->bool();

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableTools();

        return $grid;
    }
}
