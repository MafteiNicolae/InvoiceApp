<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:products,name,'.$this->product?->id,
            'description' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => "Trebuie completat numele produsului",
            'name.unique'               => "Produsul exista deja in baza de date",
            'description.required'      => "Trebuie completata descrierea produsului",
            'price.required'            => 'Trebuie completat pretul produsului',
        ];
    }
}
