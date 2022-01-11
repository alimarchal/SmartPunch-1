<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSchedule extends FormRequest
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
            'name' => [
                        'required',
                        Rule::unique('schedules')
                            ->where('business_id', auth()->user()->business_id)
                        ],
            'start_time' => 'required',
            'end_time' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'start_time.required' => 'Start time is required',
            'end_time.required' => 'End time is required',
            'break_start.required' => 'Break start is required',
            'break_end.required' => 'Break end is required',
        ];
    }
}
