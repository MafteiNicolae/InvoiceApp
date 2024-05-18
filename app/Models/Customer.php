<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function scopeFilerCustomers($query, $filters){
        return $query->when($filters['search'] ?? false,
                        fn($query, $value) => $query->where('name', 'LIKE', '%' . $value . '%')
                                                    ->orWhere('city', 'LIKE', '%' . $value . '%')
                                                    ->orWhere('county', 'LIKE', '%' . $value . '%')
                                                    ->orWhere('street', 'LIKE', '%' . $value . '%')
                                                    ->orWhere('zipcode', 'LIKE', '%' . $value . '%')
                                                );
    }

    public function scopeSortedCustomers($query){
        return $query->when(!request()->query('sort_by'), function($query){
                            $query->latest();
                        })
                    ->when(in_array(request()->query('sort_by'), ['name', 'city', 'county', 'street', 'zipcode', '-name', '-city', '-county', '-street', '-zipcode']), function($query){
                            $sortBy = request()->query('sort_by');
                            $field = ltrim($sortBy, '-');
                            $dierction = substr($sortBy, 0, 1) === '-' ? 'desc' : 'asc';
                            $query->orderBy($field, $dierction);
                        });
    }
}
