<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Counter;
use App\Models\Product;

class InvoiceController extends Controller
{

    public function index(Request $request){
        $filters= $request->only(['customer', 'invoiceNr', 'fromDate', 'toDate', 'fromDueDate', 'toDueDate', 'fromPrice', 'toPrice']);
        
        $query = Invoice::with('customer')->filter($filters)->sortedInvoices();

        return inertia('Invoice/Index', [
            'invoices' => $query->paginate(10),
            'filters' => $filters,
        ]);
    }

    public function create(){
        $customers = Customer::all();
        $counter = Counter::where('key', 'invoice')->first();
        $products = Product::all();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if($invoice){
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        }else{
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix . $counters,
            'costomer_id' => null,
            'costomer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'terms_and_conditions' => 'Default terms and conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'quantity' => 1,
                ]
            ]
        ];

        return inertia('Invoice/Create', [
            'formData' => $formData,
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    public function store(InvoiceRequest $request){
        $data = $request->validated();


        $invoice = new Invoice();
        $invoice->number = $data['number'];
        $invoice->customer_id = $data['customer_id'];
        $invoice->date = $data['date'];
        $invoice->due_date = $data['due_date'];
        $invoice->reference = $data['reference'];
        $invoice->terms_and_conditions = $data['terms_and_conditions'];
        $invoice->discount = $data['discount'];
        $invoice->sub_total = $data['sub_total'];
        $invoice->total = $data['total'];
        $invoice->save();

        foreach ($request->listCart as $item) {
            $invoice->products()->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        return redirect()->route('invoice.index')->with('message', 'Factura creata cu success');
    }

    public function show(Invoice $invoice){

        $invoice = Invoice::with(['customer', 'products'])->where('id', $invoice->id)->first();
        return inertia('Invoice/Show', [
            'invoice' => $invoice
        ]);
    }

    public function edit(Invoice $invoice){

        $customers = Customer::all();
        $products = Product::all();
        $data = Invoice::with('products')->where('id', $invoice->id)->first();

        return inertia('Invoice/Edit', [
            'invoice' => $data,
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    public function update(InvoiceRequest $request, Invoice $invoice){

        $data = $request->validated();

        $invoice->update([
            'number' => $data['number'],
            'customer_id' => $data['customer_id'],
            'date' => $data['date'],
            'due_date' => $data['due_date'],
            'reference' => $data['reference'],
            'terms_and_conditions' => $data['terms_and_conditions'],
            'discount' => $data['discount'],
            'sub_total' => $data['sub_total'],
            'total' => $data['total'],
        ]);

        $products = [];
        foreach ($request->listCart as $item) {
            $products[$item['id']] = ['quantity' => $item['quantity']];
        }
        $invoice->products()->sync($products);

        return redirect()->route('invoice.index')->with('message', 'Factura modificata cu success');

    }

    public function delete(Invoice $invoice){
        $invoice->products()->detach();
        $invoice->delete();
        return redirect()->route('invoice.index')->with('message', 'Factura steasa cu success');
    }

    public function deleteBulk(string $ids){
        
        $ids = explode(',', $ids);
        foreach($ids as $id){
            $invoice = Invoice::where('id', $id)->first();
            $invoice->products()->detach();
        }
        Invoice::destroy($ids);

        return redirect()->route('invoice.index')->with('message', "Facturi sterse cu succes");
    }
}
