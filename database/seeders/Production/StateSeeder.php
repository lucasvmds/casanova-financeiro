<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = '';
        $username = '';
        $host = '';
        $port = '';
        $database = '';
        $output = '';
        extract(config('database.connections.mysql'));
        $file = database_path('scripts/states.sql');
        exec("mysql --password=$password -h $host -P $port -u $username -D $database < $file", $output);
    }
}
