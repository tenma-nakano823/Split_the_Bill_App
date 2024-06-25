<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberEventPayRequest extends FormRequest
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
            'member_event_pays_array.*.amount' => 'nullable|integer|min:1',
            'member_event_paids_array' => 'required',
        ];
    }
}
