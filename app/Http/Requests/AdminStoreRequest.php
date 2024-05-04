<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
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
            //
            'fullname' => ['required', 'min:2'],
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'telephone' => ['required', 'min:2'],
            'gender' => ['required', 'min:2'],
            'role' => ['required', 'min:2'],
            'email' => ['required', 'unique:admins'],
           
        ];
    }
}
