<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ];
    }
}
