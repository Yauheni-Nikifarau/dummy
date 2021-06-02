<?php

namespace App\Admin\Controllers;

use App\Models\Trip;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TripController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Trip';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Trip());

        $grid->column('id', __('ID'));
        $grid->column('name', __('Name'))->filter('like');
        $grid->column('price', __('Price'))->filter('range');
        $grid->column('date_in', __('Date in'))->display(function () {
            return Carbon::parse($this->date_in)->format('Y-m-d');
        })->filter('range', 'datetime');
        $grid->column('date_out', __('Date out'))->display(function () {
            return Carbon::parse($this->date_out)->format('Y-m-d');
        })->filter('range', 'datetime');
        $grid->column('quantity_of_people', __('Quantity of people'))->filter('range');
        $grid->column('hotel', __('Hotel'))->display(function () {
            return $this->hotel->name;
        })->filter('like');
        $grid->column('country', 'Country')->display(function () {
            return $this->hotel->country;
        })->filter('like');
        $grid->column('meal_option', __('Meal option'))->filter();
        $grid->column('reservation', __('Reservation'))->bool()->filter();
        $grid->column('discount', __('Discount'))->display(function () {
            if (isset($this->discount->value)) {
                return $this->discount->value . '%';
            }
        })->filter('like');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Trip::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('price', __('Price'));
        $show->field('date_in', __('Date in'));
        $show->field('date_out', __('Date out'));
        $show->field('quantity_of_people', __('Quantity of people'));
        $show->field('hotel_id', __('Hotel id'));
        $show->field('meal_option', __('Meal option'));
        $show->field('reservation', __('Reservation'));
        $show->field('discount_id', __('Discount id'));
        $show->field('image', __('Image'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Trip());

        $form->text('name', __('Name'));
        $form->decimal('price', __('Price'));
        $form->datetime('date_in', __('Date in'))->default(date('Y-m-d H:i:s'));
        $form->datetime('date_out', __('Date out'))->default(date('Y-m-d H:i:s'));
        $form->number('quantity_of_people', __('Quantity of people'));
        $form->number('hotel_id', __('Hotel id'));
        $form->text('meal_option', __('Meal option'));
        $form->switch('reservation', __('Reservation'));
        $form->number('discount_id', __('Discount id'));
        $form->image('image', __('Image'));

        return $form;
    }
}
