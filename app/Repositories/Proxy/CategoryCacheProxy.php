<?php

namespace App\Repositories\Proxy;


use App\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class CategoryCacheProxy implements CategoryRepositoryInterface
{

    private $CategoryRepository;

    private $cache;

    public function __construct(CategoryRepositoryInterface $CategoryRepository,CacheRepository $cache)
    {
        $this->CategoryRepository = $CategoryRepository;
        $this->cache = $cache;
    }

    public function paginateCategory()
    {
        return $this->cache->remember('Category-page-'.request('page'), 60, function (){
            return $this->CategoryRepository->paginateCategory();
        });
    }

    public function paginateCategoryBySearchingTerm(string $term)
    {
        return $this->CategoryRepository->paginateCategoryBySearchingTerm($term);
    }

    public function createCategory(array $CategoryAttributes)
    {
        return $this->CategoryRepository->createCategory($CategoryAttributes);
    }

    public function findOrFail(int $id)
    {  
        return $this->cache->remember('Category'.$id, 60, function () use ($id) {
            return $this->CategoryRepository->findOrFail($id);
        });
    }

    public function updateCategory(int $CategoryID, array $CategoryAttributes)
    {
        return $this->CategoryRepository->updateCategory($CategoryID,$CategoryAttributes);
    }

    public function deleteCategory($CategoryID)
    {
        return $this->CategoryRepository->deleteCategory($CategoryID);
    }

}
