<?php

declare(strict_types=1);

namespace Database\Seeders\Develop;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(9)->create();
        User::create([
            'name' => 'Developer',
            'email' => 'dev@developer',
            'password' => password_hash('Ab123456789', PASSWORD_DEFAULT),
            'group' => 'admin',
        ]);
    }
}
