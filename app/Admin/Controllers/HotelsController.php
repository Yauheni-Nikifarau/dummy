<?php

namespace App\Admin\Controllers;

use App\Models\Hotel;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HotelsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Hotel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Hotel());

        $grid->column('name', __('Name'))->modal('Trips', function ($model) {
            $props = [
                'hotelDescription' => html_entity_decode(htmlentities($this->description)),
                'hotelName' => $this->name,
                'trips' => $this->trips,
            ];
            $props['trips']->each(function ($trip, $key) {
                $trip->date_in = Carbon::parse($trip->date_in)->format('Y-m-d');
                $trip->date_out = Carbon::parse($trip->date_out)->format('Y-m-d');
            });
            return view('admin.hotelTripsInfo', $props);
        });;
        $grid->column('stars', __('Stars'));
        $grid->column('country', __('Country'))->sortable();
        $grid->column('city', __('City'))->sortable();

        $grid->disableExport();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', 'name');
            $filter->like('country', 'country');
            $filter->like('city', 'city');
            $filter->between('stars', 'stars');
        });



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
        $show = new Show(Hotel::findOrFail($id));

        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('stars', __('Stars'));
        $show->field('country', __('Country'));
        $show->field('city', __('City'));
        $show->field('latitude', __('Latitude'));
        $show->field('longitude', __('Longitude'));
        $show->field('image', __('Image'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Hotel());

        $form->text('name', __('Name'));
        $form->summernote('description', __('Description'));
        $form->number('stars', __('Stars'));
        $form->text('country', __('Country'));
        $form->text('city', __('City'));
        $form->decimal('latitude', __('Latitude'));
        $form->decimal('longitude', __('Longitude'));
        $form->image('image', __('Image'))->move('hotels');

        return $form;
    }
}
