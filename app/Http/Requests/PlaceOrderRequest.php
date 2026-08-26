<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'phone' => ['required', 'digits:11', 'regex:/^01[0-2,5][0-9]{8}$/'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'governorate' => 'required|string|exists:shipping_settings,governorate',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'name.min' => 'Name must be at least 3 characters long.',
            'phone.required' => 'Please enter your phone number.',
            'phone.digits' => 'Phone number must be exactly 11 digits.',
            'phone.regex' => 'Phone number must start with 010, 011, 012, or 015 and contain only digits.',
            'address.required' => 'Please enter your address.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'city.required' => 'Please enter your city.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City cannot exceed 100 characters.',
            'governorate.required' => 'Please select your governorate.',
            'governorate.string' => 'Governorate must be a valid string.',
            'governorate.exists' => 'Please select a valid governorate from the list.',
        ];
    }
}
