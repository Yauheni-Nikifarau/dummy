<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTripsRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'people'       => [ 'integer', Rule::in( [ 1, 2, 3 ] ) ],
            'meal'         => [ 'string', Rule::in( [ 'OB', 'HB', 'FB', 'BB', 'AI' ] ) ],
            'min_date_in'  => 'integer',
            'max_date_in'  => 'integer',
            'min_date_out' => 'integer',
            'max_date_out' => 'integer',
            'hotel'        => 'string',
            'tag'          => 'string',
            'discount'     => 'integer',
            'min_price'    => 'integer',
            'max_price'    => 'integer',
            'order'        => [ 'string',
                Rule::in( [
                    'id',
                    'name',
                    'price',
                    'date_in',
                    'date_out',
                    'quantity_of_people',
                    'hotel_id',
                    'meal_option',
                    'created_at'
                ] )
            ],
            'direction'    => [ Rule::in( [ 'asc', 'desc' ] ) ],
            'limit'        => 'integer|min:1'
        ];
    }
}
