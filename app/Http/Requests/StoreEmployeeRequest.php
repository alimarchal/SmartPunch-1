<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'office_id' => ['required'],
            'role_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8',],
            'schedule' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'office_id.required' => __('validation.custom.office_id.required'),
            'role_id.required' => __('validation.custom.role_id.required'),
            'schedule.required' => __('validation.custom.schedule.required'),
        ];
    }
}
