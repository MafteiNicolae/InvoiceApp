<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request){
        $filters = $request->only(['search']);

        $query = Customer::filerCustomers($filters)->sortedCustomers()->paginate(10)->withQueryString();

        return inertia('Customer/Index', [
            'customers' => CustomerResource::collection($query),
            'filters' => $filters,
        ]);
    }

    public function create(){
        return inertia('Customer/Create');
    }

    public function store(CustomerRequest $request){
        $data = $request->validated();
        $customer = Customer::create($data);

        return redirect()->route('customer.index')->with('message', "Client creat cu succes");
    }

    public function edit(Customer $customer){
        return inertia('Customer/Edit', [
            'customer' => $customer
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer){
        $data = $request->validated();
        $customer->update($data);

        return redirect()->route('customer.index')->with('message', "Client modificat cu succes");
    }

    public function delete(Customer $customer){
        $customer->delete();
        return redirect()->route('customer.index')->with('message', "Client sters cu succes");
    }
    
    public function deleteBulk(string $ids){
        $ids = explode(',', $ids);
        Customer::destroy($ids);

        return redirect()->route('customer.index')->with('message', "Clienti stersi cu succes");
    }
}
