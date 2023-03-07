<?php

namespace Database\Seeders\Develop;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(20)
            ->has(Contact::factory(2))
            ->create();
    }
}
