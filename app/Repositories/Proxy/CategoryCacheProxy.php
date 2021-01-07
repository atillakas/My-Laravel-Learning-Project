<?php

namespace App\Repositories\Proxy;


use App\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class CategoryCacheProxy implements CategoryRepositoryInterface
{

    private $categoryRepository;

    private $cache;

    const CACHE_EXPIRE_TIME = 10;

    public function __construct(CategoryRepositoryInterface $categoryRepository, CacheRepository $cache)
    {
        $this->categoryRepository = $categoryRepository;
        $this->cache = $cache;
    }

    public function allCategories()
    {
        return $this->cache->remember('categories', self::CACHE_EXPIRE_TIME, function () {
            return $this->categoryRepository->allCategories();
        });
    }

    public function orWhereNotDescendantOf($id)
    {
        return $this->categoryRepository->orWhereNotDescendantOf($id);
    }

    public function paginateCategory()
    {
        return $this->cache->remember('Category-page-' . request('page'), self::CACHE_EXPIRE_TIME, function () {
            return $this->categoryRepository->paginateCategory();
        });
    }

    public function paginateCategoryBySearchingTerm(string $term)
    {
        return $this->categoryRepository->paginateCategoryBySearchingTerm($term);
    }

    public function createCategory(array $CategoryAttributes)
    {
        return $this->categoryRepository->createCategory($CategoryAttributes);
    }

    public function findOrFail(int $id)
    {
        return $this->cache->remember('Category' . $id, self::CACHE_EXPIRE_TIME, function () use ($id) {
            return $this->categoryRepository->findOrFail($id);
        });
    }

    public function updateCategory(int $CategoryID, array $CategoryAttributes)
    {
        return $this->categoryRepository->updateCategory($CategoryID, $CategoryAttributes);
    }

    public function deleteCategory($CategoryID)
    {
        return $this->categoryRepository->deleteCategory($CategoryID);
    }
}
