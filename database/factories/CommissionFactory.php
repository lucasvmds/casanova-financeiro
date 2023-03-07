<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commission>
 */
class CommissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $proposal = Proposal::inRandomOrder()->first([
            'id',
            'required_amount',
        ]);
        $commission = Configuration::first('seller_commission')->seller_commission;
        return [
            'user_id' => User::inRandomOrder()->first('id')->id,
            'proposal_id' => $proposal->id,
            'amount' => ($proposal->required_amount / 100) * $commission,
            'percentage' => $commission,
        ];
    }
}
