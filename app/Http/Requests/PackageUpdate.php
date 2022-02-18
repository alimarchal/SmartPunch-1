<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class PackageUpdate extends FormRequest
{
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
            'business_id' => 'required',
            'package_id' => 'required',
            'package_type' => 'required',
            'card_number' => 'required',
            'cvv' => 'required',
            'card_valid_from' => 'required',
            'card_valid_to' => 'required',
            'amount' => 'required',
            'bank_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'business_id.required' => 'Business ID is required',
            'package_id' => 'Package ID is required',
            'package_type' => 'Package type is required',
            'card_number' => 'Card number is required',
            'cvv' => 'Card\'s cvv is required',
            'card_valid_from' => 'Card\'s issue date is required',
            'card_valid_to' => 'Card\'s expiry date is required',
            'amount' => 'Total amount is required',
            'bank_name' => 'Bank name is required',
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()){
            return new JsonResponse($errors, 422);
        }
    }
}
