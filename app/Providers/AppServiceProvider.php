<?php

namespace App\Providers;

use App\Repositories\Ideas\IdeasRepository;
use App\Repositories\Ideas\IdeasRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        $this->app->bind(IdeasRepositoryInterface::class, IdeasRepository::class);
    }
}
