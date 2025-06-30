<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeRoleRequest extends FormRequest
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
            'name' => 'required|unique:role,name',

            'permission' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Le nom de role est requis',
            'name.unique' => 'Le nom de role  est déja pris',
            'permission' => 'Le nom de permission est requis',

        ];
    }
}