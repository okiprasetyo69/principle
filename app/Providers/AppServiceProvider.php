<?php

namespace App\Providers;

use App\Models\User;
use App\Models\DistributorStock;
use App\Observers\DistibutorObserver;
use App\Observers\PrincipalObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\Paginator;

use App\Services\Interfaces\UserService;
use App\Services\Interfaces\CategoryService;
use App\Services\Interfaces\ProductService;
use App\Services\Interfaces\PurchaseOrderService;
use App\Services\Interfaces\DistributorStockService;

use App\Services\Repositories\UserRepositoryEloquent;
use App\Services\Repositories\CategoryRepositoryEloquent;
use App\Services\Repositories\ProductRepositoryEloquent;
use App\Services\Repositories\PurchaseOrderRepositoryEloquent;
use App\Services\Repositories\DistributorStockRepositoryEloquent;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserService::class => UserRepositoryEloquent::class,
        CategoryService::class => CategoryRepositoryEloquent::class,
        ProductService::class => ProductRepositoryEloquent::class,
        PurchaseOrderService::class => PurchaseOrderRepositoryEloquent::class,
        DistributorStockService::class => DistributorStockRepositoryEloquent::class,
    ];

    public function provides() : array{
        return [
            UserService::class,
            CategoryService::class,
            ProductService::class,
            PurchaseOrderService::class,
            DistributorStockService::class,
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
        Paginator::useBootstrap(); 
        DistributorStock::observe(DistibutorObserver::class);
        DistributorStock::observe(PrincipalObserver::class);
    }
}
