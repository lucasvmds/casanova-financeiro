<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $state_id = State::inRandomOrder()
            ->first('id')
            ->id;
        $city_id = City::where('state_id', $state_id)
            ->first('id')
            ->id;

        return [
            'state_id' => $state_id,
            'city_id' => $city_id,
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###########'),
            'rg' => fake()->numerify('#########'),
            'birth_date' => fake()->dateTimeBetween('-70 years', '-20 years'),
            'street' => fake()->streetAddress(),
            'number' => fake()->numerify('####'),
            'district' => ucwords( fake()->words(asText: true) ),
            'cep' => fake()->numerify('########'),
        ];
    }
}
