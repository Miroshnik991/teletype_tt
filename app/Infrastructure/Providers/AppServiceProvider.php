<?php

namespace App\Infrastructure\Providers;

use App\Domain\Factories\ClientFactoryInterface;
use App\Domain\Factories\DialogFactoryInterface;
use App\Domain\Factories\MessageFactoryInterface;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Domain\Repositories\DialogRepositoryInterface;
use App\Domain\Repositories\MessageRepositoryInterface;
use App\Infrastructure\Factories\ClientFactory;
use App\Infrastructure\Factories\DialogFactory;
use App\Infrastructure\Factories\MessageFactory;
use App\Infrastructure\Repositories\ClientRepository;
use App\Infrastructure\Repositories\DialogRepository;
use App\Infrastructure\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientRepositoryInterface::class, function () {
            return new ClientRepository();
        });

        $this->app->singleton(DialogRepositoryInterface::class, function () {
            return new DialogRepository();
        });

        $this->app->singleton(MessageRepositoryInterface::class, function () {
            return new MessageRepository();
        });

        $this->app->singleton(ClientFactoryInterface::class, function () {
            return new ClientFactory();
        });

        $this->app->singleton(DialogFactoryInterface::class, function () {
            return new DialogFactory();
        });

        $this->app->singleton(MessageFactoryInterface::class, function () {
            return new MessageFactory();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
