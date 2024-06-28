<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')){
            $response = ApiResponse::sendResponse(422,'Validation Error',$validator->messages()->all());
            throw new ValidationException($validator,$response);
        }
    }
    public function rules(): array
    {
        return [
            'title' => 'required',
            'slug' => 'required',
            'text' => 'required',
            'phone' => 'required',
            'domain_id' => 'required|exists:domains,id',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return[
            'title' => 'يجب اضافة العنوان',
            'slug' => 'يجب اضافة slug',
            'text' => 'يجب اضافة text',
            'phone' => 'يجب اضافة phone',
            'domain_id' => 'يجب اضافة domain_id',
        ];
    }
}
