<?php

namespace App\Providers;

use App\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductCacheRepository;
use App\Repositories\ProductCacheFacadeRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductRepositoryInterface::class,function(){
            $productRepository = new ProductRepository;
            $cacheRepository = new ProductCacheRepository($productRepository,$this->app['cache.store']);
            return $cacheRepository;
        });

        //facade
        // $this->app->singleton(ProductRepositoryInterface::class,function(){
        //     $productRepository = new ProductRepository;
        //     $cacheRepository = new ProductCacheFacadeRepository($productRepository);
        //     return $cacheRepository;
        // });
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
