<?php

namespace App\Repositories\Proxy;


use App\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class ProductCacheRepository implements ProductRepositoryInterface
{

    private $productRepository;

    private $cache;

    const CACHE_EXPIRE_TIME = 10;

    public function __construct(ProductRepositoryInterface $productRepository, CacheRepository $cache)
    {
        $this->productRepository = $productRepository;
        $this->cache = $cache;
    }

    public function paginateProduct()
    {
        return $this->cache->remember('product-page-' . request('page'), self::CACHE_EXPIRE_TIME, function () {
            return $this->productRepository->paginateProduct();
        });
    }

    public function paginateProductBySearchingTerm(string $term)
    {
        return $this->productRepository->paginateProductBySearchingTerm($term);
    }

    public function createProduct(array $productAttributes)
    {
        return $this->productRepository->createProduct($productAttributes);
    }

    public function findOrFail(int $id)
    {
        return $this->cache->remember('product' . $id, self::CACHE_EXPIRE_TIME, function () use ($id) {
            return $this->productRepository->findOrFail($id);
        });
    }

    public function updateProduct(int $productID, array $productAttributes)
    {
        return $this->productRepository->updateProduct($productID, $productAttributes);
    }

    public function deleteProduct($productID)
    {
        return $this->productRepository->deleteProduct($productID);
    }

    public function syncProductWithCategory(int $product_id, array $categories)
    {
        return $this->productRepository->syncProductWithCategory($product_id,$categories);
    }
}
