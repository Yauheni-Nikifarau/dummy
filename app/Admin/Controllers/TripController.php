<?php

namespace App\Admin\Controllers;

use App\Models\Discount;
use App\Models\Hotel;
use App\Models\Tag;
use App\Models\Trip;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Hash;

class TripController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Trip';


    /**
     * Responds to AJAX request from Trip Creating or editing Form When user write something in "Hotel" field
     *
     * @return mixed
     */
    public function findHotelsByName()
    {
        $q = request()->input('q', null);

        return Hotel::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    /**
     * Responds to AJAX request from Trip Creating or editing Form When user write something in "Discount" field
     *
     * @return mixed
     */
    public function findDiscountsByValue()
    {
        $q = request()->input('q', null);

        return Discount::where('value', 'like', "%$q%")->paginate(null, ['id', 'value as text']);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Trip());

        $grid->column('id', __('ID'))->sortable();

        $grid->column('name', __('Name'))->modal('Trip', function ($model) {
            $props = [
                'image' => $this->image,
                'tags' => $this->tags,
            ];
            return view('admin.tripInfo', $props);
        });;

        $grid->column('price', __('Price'))->sortable();

        $grid->column('date_in', __('Date in'))->display(function () {
            return Carbon::parse($this->date_in)->format('Y-m-d');
        })->sortable();

        $grid->column('date_out', __('Date out'))->display(function () {
            return Carbon::parse($this->date_out)->format('Y-m-d');
        })->sortable();

        $grid->column('quantity_of_people', __('Quantity of people'))->sortable();

        $grid->column('hotel', __('Hotel'))->display(function () {
            return $this->hotel->name;
        });

        $grid->column('country', 'Country')->display(function () {
            return $this->hotel->country . "({$this->hotel->city})";
        });

        $grid->column('meal_option', __('Meal option'));

        $grid->column('reservation', __('Reservation'))->bool()->filter([
            0 => 'Free',
            1 => 'Booked',
        ]);

        $grid->column('discount', __('Discount'))->display(function () {
            if (isset($this->discount->value)) {
                return $this->discount->value . '%';
            }
        });

        $grid->column('price_with_discount', __('Price with discount'))->display(function () {
            if (isset($this->discount->value)) {
                $endPrice = $this->price * ((100 - $this->discount->value) / 100);
                return number_format($endPrice, 2);
            }
        });

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', 'Name');
                $filter->between('price', 'Price');
                $filter->between('date_in', 'Date in')->datetime();
                $filter->between('date_out', 'Date out')->datetime();
            });

            $filter->column(1 / 2, function ($filter) {
                $filter->equal('quantity_of_people', 'Quantity of people')->decimal();
                $filter->like('meal_option', 'Meal Option');
                $filter->where(function ($query) {

                    $query->whereHas('hotel', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });

                }, 'Hotel');
                $filter->where(function ($query) {

                    $query->whereHas('hotel', function ($query) {
                        $query->where('country', 'like', "%{$this->input}%");
                    });

                }, 'Country');
            });
        });

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
        $form = new Form(new Trip());

        $form->text('name', __('Name'))->rules('required');
        $form->decimal('price', __('Price'))->rules('required');
        $form->date('date_in', __('Date in'))->default(Carbon::today())->rules('required');
        $form->date('date_out', __('Date out'))->default(Carbon::today())->rules('required');
        $form->number('quantity_of_people', __('Quantity of people'))->rules('min:1|max:2');

        $form->select('hotel_id', 'Hotel')->options(function ($id) {
            $hotel = Hotel::find($id);

            if ($hotel) {
                return [$hotel->id => "{$hotel->name} ({$hotel->country})"];
            }
        })->ajax('/admin/find/hotels');

        $form->select('meal_option', 'Meal option')->options(['OB' => 'OB', 'HB' => 'HB', 'FB' => 'FB', 'BB' => 'BB', 'AI' => 'AI']);
        $form->select('discount_id', 'Discount')->options(function ($id) {
            $discount = Discount::find($id);

            if ($discount) {
                return [$discount->id => $discount->value . '%'];
            }
        })->ajax('/admin/find/discounts');

        $form->radio('reservation', 'Reservation')->options([true => 'booked', false => 'free'])->default(false);
        $form->multipleSelect('tags', 'Tags')->options(Tag::all()->pluck('tag_name', 'id'));
        $form->image('image', __('Image'))->move('tripsWallpapers');

        return $form;
    }
}
