<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('dateControl', function (bool $softDelete = false): void {
            /** @var Blueprint */
            $table = $this;
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            if ($softDelete) $table->dateTime('deleted_at')->nullable();
        });
    }
}
