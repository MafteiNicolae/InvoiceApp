<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }

    public function scopeFilterProducts($query, $filters){
        return $query->when($filters['search'] ?? false, 
            fn($query, $value) => $query->where('name', 'LIKE', '%' . $value . '%'));
    }

    public function scopeSortedProducts($query){
        return $query->when(!request()->query('sort_by'), function($query){
                            $query->latest();
                        })
                    ->when(in_array(request()->query('sort_by'), ['name', 'description', 'price', '-name', '-description', '-price', '-street', '-zipcode']), function($query){
                            $sortBy = request()->query('sort_by');
                            $field = ltrim($sortBy, '-');
                            $dierction = substr($sortBy, 0, 1) === '-' ? 'desc' : 'asc';
                            $query->orderBy($field, $dierction);
                        });
    }
}
