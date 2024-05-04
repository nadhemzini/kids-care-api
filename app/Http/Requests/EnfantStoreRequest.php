<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnfantStoreRequest extends FormRequest
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
            'fullname' => ['required', 'min:2'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => ['required', 'min:2'],
            'parent_id' => ['required', ],
            'class_id' => ['required', ],
            //
        ];
    }
}
