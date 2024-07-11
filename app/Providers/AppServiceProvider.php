<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\Paginator;

use App\Services\Interfaces\UserService;
use App\Services\Interfaces\CategoryService;
use App\Services\Interfaces\ProductService;

use App\Services\Repositories\UserRepositoryEloquent;
use App\Services\Repositories\CategoryRepositoryEloquent;
use App\Services\Repositories\ProductRepositoryEloquent;


class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserService::class => UserRepositoryEloquent::class,
        CategoryService::class => CategoryRepositoryEloquent::class,
        ProductService::class => ProductRepositoryEloquent::class,
    ];

    public function provides() : array{
        return [
            UserService::class,
            CategoryService::class,
            ProductService::class,
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
