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
        $this->mergeConfigFrom(__DIR__.'/../config/http-logger.php', 'http-logger');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/http-logger.php' => config_path('http-logger.php'),
            ], 'config');
        }

        $this->app->singleton(LogProfile::class, config('http-logger.log_profile'));
        $this->app->singleton(LogWriter::class, config('http-logger.log_writer'));

        $this->app->bind(IdeasRepositoryInterface::class, IdeasRepository::class);
    }
}
