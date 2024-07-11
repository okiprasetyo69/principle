<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\Paginator;

use App\Services\Interfaces\UserService;
use App\Services\Interfaces\CategoryService;

use App\Services\Repositories\UserRepositoryEloquent;
use App\Services\Repositories\CategoryRepositoryEloquent;


class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserService::class => UserRepositoryEloquent::class,
        CategoryService::class => CategoryRepositoryEloquent::class,
    ];

    public function provides() : array{
        return [
            UserService::class,
            CategoryService::class,
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
