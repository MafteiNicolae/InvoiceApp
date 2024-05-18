<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:customers,name,' . $this->customer?->id,
            'city' => 'required|string',
            'county' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
            'zipcode' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => "Trebuie completat numele clientului",
            'name.unique'       => "Clientul exista deja in baza de date",
            'city.required'     => "Trebuie completat orasul",
            'county.required'   => 'Trebuie completat judetul',
            'street.required'   => 'Trebuie conformata strada',
            'number.required'   => 'Trebuie conformat codul postal',
            'zipcode.required'  => 'Trebuie conformat codul postal',
        ];
    }
}
