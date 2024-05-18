<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'number' => 'required',
            'customer_id' => ['required', 
                                'exists:customers,id'
                                ],
            'date' => 'required|date',
            'due_date' => 'required|date|after:date',
            'reference' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'sub_total' => 'required|numeric|min:1',
            'discount' => 'required|numeric',
            'total' => 'required|numeric|min:1',
          ];
    }

    public function messages(): array
    {
        return [
            'number.required'       => "Trebuie completat numarul facturii",
            'number.unique'         => "Exista deja o factura cu acest numar",
            'customer_id.required'  => "Trebuie completat numele clientului",
            'customer_id.exists'    => "NUmele selectat nu exista in lista de clienti",
            'date.required'         => 'Trebuie completata data',
            'due_date.required'     => 'Trebuie conformata data scadenta',
            'due_date.after'        => 'Scadenta trebuie sa fie ulterioara emiterii',
            'sub_total.required'    => 'Trebuie sa existe un subtotal',
            'sub_total.min'         => 'Subtotalul trebuie sa fie mai mare de 0',
            'discount.required'     => 'Trebuie completat discountul. Daca nu exista trebuie completat 0',
            'discount.numeric'      => 'In campul discoungt trebuie introdus un numar',
            'total.required'        => 'Trebuie completat totalul',
            'total.min'             => 'Totalul trebuie sa fie mai mare de 0',
        ];
    }

}
