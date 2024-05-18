<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => "Trebuie completat numele",
            'email.required'     => "Trebuie completata adresa de email",
            'password.required' => 'Trebuie completata parola',
            'password_confirmation.required' => 'Trebuie conformata parola',
        ];
    }

}
