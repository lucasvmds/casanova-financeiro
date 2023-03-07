<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first('id')->id,
            'status_id' => 1,
            'customer_id' => Customer::inRandomOrder()->first('id')->id,
            'product_id' => Product::inRandomOrder()->first('id')->id,
            'required_amount' => fake()->randomFloat(2, 5000.00, 500000.00),
        ];
    }
}
