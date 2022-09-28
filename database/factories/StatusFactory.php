<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucwords( fake()->words(2, true) ),
            'main' => fake()->randomElement(['open', 'approved', 'closed']),
            'color' => '#000000',
        ];
    }

    /**
     * Cria os status inicias presentes no ambiente de produção
     * 
     * @param string $status
     * @return static
     */
    public function production(string $status)
    {
        $production_statuses = [
            'open' => [
                'name' => 'Em Aberto',
                'main' => 'open',
            ],
            'approved' => [
                'name' => 'Aprovado',
                'main' => 'approved',
            ],
            'closed' => [
                'name' => 'Fechado',
                'main' => 'closed',
            ],
        ];

        return $this->state(function(array $attributes) use($status, $production_statuses) {
            return $production_statuses[$status];
        });
    }
}
