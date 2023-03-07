<?php

namespace Database\Seeders\Develop;

use App\Models\Proposal;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    use WithoutModelEvents;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proposal::factory(5)
            ->hasAttached(
                Status::factory(),
                [ 'note' => fake()->words(asText: true), ],
            )
            ->create();
    }
}
