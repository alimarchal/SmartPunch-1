<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class IbrStoreRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:ibrs'],
            'password' => ['required', 'min:8', 'confirmed'],
            'dob' => ['required', 'date', 'before_or_equal:'. Carbon::now()],
            'gender' => ['required'],
            'country_of_business' => ['required'],
            'country_of_bank' => ['required'],
            'bank' => ['required'],
            'iban' => ['required'],
            'currency' => ['required'],
            'mobile_number' => ['required'],
            'terms' => ['required'],
            'mac_address' => ['filled'],
            'device_name' => ['filled'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.custom.name.required'),
            'email.required' => __('validation.email'),
            'dob.required' => __('validation.required', ['attribute' => __('register.Date of birth')]),
            'dob.date' => __('validation.date', ['attribute' => __('register.Date of birth')]),
            'dob.before_or_equal' => __('validation.before_or_equal', ['attribute' => __('register.Date of birth'), 'date' => Carbon::now()->format('m/d/y')]),
            'gender.required' => __('validation.required', ['attribute' => __('register.Gender')]),
            'country_of_business.required' => __('validation.custom.country_of_business.required'),
            'country_of_bank.required' => __('validation.custom.country_of_bank.required'),
            'bank.required' => __('validation.custom.bank.required'),
            'iban.required' => __('validation.custom.iban.required'),
            'currency.required' => __('validation.custom.currency.required'),
            'mobile_number.required' => __('validation.custom.mobile_number.required'),
            'mac_address.filled' => 'Missing mac address',
            'device_name.filled' => 'Missing device name',
            /* Terms and conditions error being displayed using register view */
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson())
        {
            return new JsonResponse($errors,422);
        }
    }
}
