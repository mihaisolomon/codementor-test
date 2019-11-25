<?php

namespace App\Providers;

use App\Repositories\BlackListTokens\BlackListTokensRepository;
use App\Repositories\BlackListTokens\BlackListTokensRepositoryInterface;
use App\Repositories\Ideas\IdeasRepository;
use App\Repositories\Ideas\IdeasRepositoryInterface;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\UsersRepositoryInterface;
use App\Services\BlackListTokens\BlackListTokensService;
use App\Services\BlackListTokens\BlackListTokensServiceInterface;
use App\Services\JWT\JwtService;
use App\Services\JWT\JwtServiceInterface;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceInterface;
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

        /**
         * Repositories
         */
        $this->app->singleton(IdeasRepositoryInterface::class, IdeasRepository::class);
        $this->app->singleton(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->singleton(BlackListTokensRepositoryInterface::class, BlackListTokensRepository::class);

        /**
         * Services
         */
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(JwtServiceInterface::class, JwtService::class);
        $this->app->singleton(BlackListTokensServiceInterface::class, BlackListTokensService::class);
    }
}
