<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $customerId = $this->route('customer') ? $this->route('customer')->id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:customers,email,' . $customerId, // Allow the same email for the current customer on update
            ],
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:255',
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg',
                'max:2048',
            ], // Validate logo image
            'header_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg',
                'max:2048',
            ], // Validate header image
            'description' => 'nullable|string|min:5|max:255',
        ];
    }

    /**
     * Modify the validated data before returning it.
     *
     * @return array
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower($this->email), // Normalize email to lowercase
        ]);
    }
}
