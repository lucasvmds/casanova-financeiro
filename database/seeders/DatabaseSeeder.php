<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Develop\CommissionSeeder;
use Database\Seeders\Develop\CustomerSeeder;
use Database\Seeders\Develop\PartnerSeeder;
use Database\Seeders\Develop\ProposalSeeder;
use Database\Seeders\Production\UserSeeder;
use Database\Seeders\Production\CitySeeder;
use Database\Seeders\Production\ConfigurationSeeder;
use Database\Seeders\Production\StateSeeder;
use Database\Seeders\Production\StatusSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            StateSeeder::class,
            CitySeeder::class,
            StatusSeeder::class,
            ConfigurationSeeder::class,
            UserSeeder::class
        ];

        if (app()->environment() !== 'production') {
            $seeders[] = CustomerSeeder::class;
            $seeders[] = PartnerSeeder::class;
            $seeders[] = ProposalSeeder::class;
            $seeders[] = CommissionSeeder::class;
        }

        $this->call($seeders);
    }
}
