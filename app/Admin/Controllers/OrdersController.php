<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));
        $grid->column('trip', __('Trip'))->display(function () {
            return $this->trip->name;
        });
        $grid->column('user', __('User'))->display(function () {
            return $this->user->name . ' ' . $this->user->surname . " ({$this->user->email})";
        });
        $grid->column('paid', __('Paid'))->bool()->filter([
            0 => 'No',
            1 => 'Yes',
        ]);
        $grid->column('reservation_expires', __('Reservation expires'))->sortable();
        $grid->column('price', __('Price'));

        $grid->disableFilter();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());

        $form->switch('paid', __('Paid'));
        $form->datetime('reservation_expires', __('Reservation expires'))->default(date('Y-m-d H:i:s'));
        $form->decimal('price', __('Price'));

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });



        return $form;
    }
}
