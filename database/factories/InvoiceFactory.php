<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        static $number= 20001;

        return [
            'number' => 'INV-' . $number++,
            'customer_id' => fake()->numberBetween(7, 26),
            'date' => fake()->date(),
            'due_date' => fake()->date(),
            'reference' => 'REF' . fake()->word(),
            'terms_and_conditions' => fake()->sentence(),
            'sub_total' => fake()->numberBetween(100, 1000),
            'discount' => fake()->numberBetween(10, 200),
            'total' => fake()->numberBetween(100, 10000),
        ];
    }
}
