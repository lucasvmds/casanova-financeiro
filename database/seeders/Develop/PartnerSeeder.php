<?php

namespace Database\Seeders\Develop;

use App\Models\Partner;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    use WithoutModelEvents;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::factory(5)
            ->has(Product::factory(2))
            ->create();
    }
}
