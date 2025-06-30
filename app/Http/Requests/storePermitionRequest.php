<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storePermitionRequest extends FormRequest
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
            'name' => 'required|unique:permissions,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de permission est requis',
            'name.unique' => 'Le nom de permission  est déja pris',

        ];
    }
}
