<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassStoreRequest extends FormRequest
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
            'nom_de_class' => ['required', 'min:2' ,'unique:classes'],
            'emploi_de_temps' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            //
        ];
    }
}
