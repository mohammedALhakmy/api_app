<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class NewMessageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')){
$response = ApiResponse::sendResponse(422,'Validation Error0',$validator->messages()->all());
throw new ValidationException($validator,$response);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ];
    }

    public function attributes()
    {
        return[
          'name' => 'يجب اضافة الاسم',
          'email' => 'يجب اضافة الايميل',
          'email' => 'يجب اضافة الايميل ومن نوع ايميل',
          'phone' => 'يجب اضافة رقم الهاتف',
          'message' => 'يجب اضافة الرساله',
        ];
    }

}
