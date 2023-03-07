<?php

namespace Database\Seeders\Develop;

use App\Models\Commission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    use WithoutModelEvents;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Commission::factory(10)->create();
    }
}
