<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializa a BD';

    private function dbIsInitialized(): bool
    {
        return (bool) DB::table('users')->count('id');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->warn('Initializing DB');
        if (! $this->dbIsInitialized()) {
            $this->info('Seeding records');
            $this->call('db:seed', ['--force' => true,]);
        } else {
            $this->info('Nothing to do');
        }
        return 0;
    }
}
