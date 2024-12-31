<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string',
            'description' => 'required|string',
            'work_date' => 'required|date',
            'time_spent' => 'nullable|integer|min:0',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
        ];
    }
}
