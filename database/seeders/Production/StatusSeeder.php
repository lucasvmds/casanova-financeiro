<?php

namespace Database\Seeders\Production;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    use WithoutModelEvents;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::factory()->production('open')->create();
        Status::factory()->production('closed')->create();
        Status::factory()->production('approved')->create();
    }
}
