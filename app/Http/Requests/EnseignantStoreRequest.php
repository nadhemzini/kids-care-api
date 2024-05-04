<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnseignantStoreRequest extends FormRequest
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
            
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|unique:enseignants,email',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gender' => 'required|string|max:255',
                // 'matiere_ids' => 'required|array', // Assuming matiere_ids are sent as an array
                // 'class_ids' => 'required|array', // Assuming class_ids are sent as an array
            ];
    }
}
