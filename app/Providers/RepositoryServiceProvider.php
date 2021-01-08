<?php

namespace App\Providers;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Decorator\CategoryBreadcrumbDecorator;
use App\Repositories\Proxy\CategoryCacheProxy;
use App\Repositories\ProductRepository;
use App\Repositories\Proxy\ProductCacheRepository;
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

        $this->app->singleton(CategoryRepositoryInterface::class,function(){
            $categoryRepository = new CategoryRepository();
            $categoryModel = new Category();
            $categoryBreadCrumbsDecorator = new CategoryBreadcrumbDecorator($categoryRepository,$categoryModel);
            // $cacheCategoryProxy = new CategoryCacheProxy($categoryRepository,$this->app['cache.store']);
            $cacheCategoryProxy = new CategoryCacheProxy($categoryBreadCrumbsDecorator,$this->app['cache.store']);
            return $cacheCategoryProxy;
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
