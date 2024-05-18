<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Product;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['quantity']);
    }

    public function scopeFilter($query, $filters){
        return  $query ->when($filters['invoiceNr'] ?? false,
                        fn($query, $value) => $query->where('number', 'LIKE', '%' . $value . '%'))
                    ->when($filters['fromDate'] ?? false,
                        fn($query, $value) => $query->where('date', '>=', $value ))
                    ->when($filters['toDate'] ?? false,
                        fn($query, $value) => $query->where('date', '<=', $value ))  
                    ->when($filters['fromDueDate'] ?? false,
                        fn($query, $value) => $query->where('due_date', '>=', $value ))
                    ->when($filters['toDueDate'] ?? false,
                        fn($query, $value) => $query->where('due_date', '<=', $value ))
                    ->when($filters['fromPrice'] ?? false,
                        fn($query, $value) => $query->where('total', '>=', $value ))
                    ->when($filters['toPrice'] ?? false,
                        fn($query, $value) => $query->where('total', '<=', $value )) 
                    ->when($filters['customer'] ?? false, 
                        fn($query, $value) => $query->whereHas('customer', function($query) use($value){
                                $query->where('name', 'LIKE', '%' . $value . '%');
                        }));
    }

    public function scopeSortedInvoices($query){
        return $query->when(!request()->query('sort_by'), function($query){
                            $query->latest();
                        })
                    ->when(in_array(request()->query('sort_by'), ['customer_id', 'number', 'date', 'due_date', 'total', '-customer_id', '-number', '-date', '-due_date', '-total']), function($query){
                            $sortBy = request()->query('sort_by');
                            $field = ltrim($sortBy, '-');
                            $direction = substr($sortBy, 0, 1) === '-' ? 'desc' : 'asc';
                            if($field === 'customer_id'){
                                $query->orderBy(Customer::select('name')->whereColumn('customers.id', 'invoices.customer_id'), $direction);
                            }
                            $query->orderBy($field, $direction);
                        });
    }
}
