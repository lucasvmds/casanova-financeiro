<?php

declare(strict_types=1);

namespace Database\Seeders\Production;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        if (app()->environment() === 'production') {
            User::create([
                'name' => 'Administrador',
                'email' => config('app.initial_user.email'),
                'password' => Hash::make(config('app.initial_user.password')),
                'group' => 'admin',
            ]);
        } else {
            User::factory(9)->create();
            User::create([
                'name' => 'Developer',
                'email' => 'dev@developer',
                'password' => Hash::make('Ab123456789'),
                'group' => 'admin',
            ]);
        }
    }
}
