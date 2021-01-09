<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProductCacheFacadeRepository implements ProductRepositoryInterface
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function paginateProduct()
    {
        return Cache::remember('product-page-'.request('page'), 60, function (){
            return $this->productRepository->paginateProduct();
        });
    }

    public function paginateProductBySearchingTerm(string $term)
    {
        return Cache::remember('product-page-'.request('page'), 60, function () use ($term) {
            return $this->productRepository->paginateProductBySearchingTerm($term);
        });
    }

    public function createProduct(array $productAttributes)
    {   Cache::flush();
        return $this->productRepository->createProduct($productAttributes);
    }

    public function findOrFail(int $id)
    {  
        return Cache::remember('product'.$id, 60, function () use ($id) {
            return $this->productRepository->findOrFail($id);
        });
    }

    public function updateProduct(int $productID, array $productAttributes)
    {
        Cache::flush();
        return $this->productRepository->updateProduct($productID,$productAttributes);
    }

    public function deleteProduct($productID)
    {
        Cache::flush();
        return $this->productRepository->deleteProduct($productID);
    }

}
