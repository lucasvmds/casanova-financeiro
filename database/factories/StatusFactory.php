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
        $name = ucwords( fake()->words(asText: true) );
        return [
            'name' => $name,
            'code' => strtolower(
                preg_replace('/\s/', '-', $name)
            ),
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
                'code' => 'em-aberto',
            ],
            'approved' => [
                'name' => 'Aprovado',
                'code' => 'aprovado',
            ],
            'closed' => [
                'name' => 'Fechado',
                'code' => 'fechado',
            ],
        ];

        return $this->state(function(array $attributes) use($status, $production_statuses) {
            return $production_statuses[$status];
        });
    }
}
