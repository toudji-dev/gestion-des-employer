<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class submitDefineAccessRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|exists:reset_code_passwords,code',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Le code est requis.',
            'code.exists' => 'Ce code n\'est pas valide. Consultez votre boite email.',
            'password.same' => 'Les mots de passe ne correspondent pas.',
            'confirm_password.same' => 'Les mots de passe ne correspondent pas.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'confirm_password.required' => 'Le champ de confirmation du mot de passe est obligatoire.'
        ];
    }
}
