<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Counter;
use App\Models\Product;
use App\Models\Invoice;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Customer::factory(30)->create();
        // Product::factory(50)->create();
        // Counter::factory(1)->create();
        
        // User::factory()->create([
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
            // ]);
   
            
        Invoice::factory(15)->create()->each(function ($invoice) {
                // Seed pivot table
                $invoice->products()->attach(Product::factory(rand(1, 3))->create(), ['quantity' => 1]);
                // You can adjust the quantity or attach multiple products as needed
            });

            
//             Invoice::factory(30)->create();
//             $products = Product::all();
//     Invoice::all()->each(function ($invoice) use ($products) { 
//     $invoice->products()->attach(
//         $products->random(rand(1, 3))->pluck('id')->toArray()
//     ); 
// });

    }
}
