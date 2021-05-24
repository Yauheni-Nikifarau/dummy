<?php

namespace App\Http\Requests;

use App\Http\Traits\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class IndexMessageRequest extends FormRequest
{
    use ResponseHandler;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'way' => 'string|in:inbox,sent,dialogue',
            'to' => 'required_if:way,dialogue|integer|exists:users,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new ValidationException(
                $validator,
                $this->responseError('The given data was invalid',
                400,
                $this->validator->errors())
        ));
    }
}
