<?php

namespace App\Providers;

use App\Repositories\Ideas\IdeasRepository;
use App\Repositories\Ideas\IdeasRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Spatie\HttpLogger\LogProfile;
use Spatie\HttpLogger\LogWriter;

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

        $this->app->singleton(LogProfile::class, \Spatie\HttpLogger\LogNonGetRequests::class);
        $this->app->singleton(LogWriter::class, \Spatie\HttpLogger\DefaultLogWriter::class);

        $this->app->bind(IdeasRepositoryInterface::class, IdeasRepository::class);
    }
}
