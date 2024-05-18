<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){
        $filters = $request->only(['search']);

        $query = Product::filterProducts($filters)->sortedProducts()->paginate(10)->withQueryString();
        return inertia('Product/Index', [
            'products' => ProductResource::collection($query), 
            'filters' => $filters,
                        ]);
    }

    public function create(){
        return inertia('Product/Create');
    }

    public function store(ProductRequest $request){
        $data = $request->validated();
        $product = Product::create($data);

        return redirect()->route('product.index')->with('message', 'Produs creat cu succes!');
    }

    public function edit(Product $product){
        return inertia('Product/Edit', [
            'product' => $product,
        ]);
    }

    public function update(ProductRequest $request, Product $product){
        $data = $request->validated();
        $product->update($data);

        return redirect()->route('product.index')->with('message', 'Produs modificat cu succes!');
    }

    public function delete(Product $product){
        $product->delete();

        return redirect()->route('product.index')->with('message', 'Produs sters cu succes!');
    }

    public function deleteBulk(string $ids){
        $ids = explode(',', $ids);
        Product::destroy($ids);
        return redirect()->route('product.index')->with('message', 'Produse sterse cu succes!');
    }
}
