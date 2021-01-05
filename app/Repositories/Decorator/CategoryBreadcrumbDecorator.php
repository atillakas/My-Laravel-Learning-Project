<?php

namespace App\Repositories\Decorator;


use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;


class CategoryBreadcrumbDecorator implements CategoryRepositoryInterface
{

    private $CategoryRepository;

    private $categoryModel;

    public function __construct(CategoryRepositoryInterface $CategoryRepository, Category $categoryModel)
    {
        $this->CategoryRepository = $CategoryRepository;
        $this->categoryModel = $categoryModel;
    }

    public function paginateCategory()
    {
         $paginate =  $this->CategoryRepository->paginateCategory();
         $paginate->getCollection()->map(function ($item) {
            $result = $this->categoryModel->defaultOrder()->ancestorsAndSelf($item->id)->toArray();
            $item->name = implode(' &#11162; ', array_column($result, "name"));
            return $item;
        });
        return $paginate;
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
        return $this->cache->remember('Category' . $id, 60, function () use ($id) {
            return $this->CategoryRepository->findOrFail($id);
        });
    }

    public function updateCategory(int $CategoryID, array $CategoryAttributes)
    {
        return $this->CategoryRepository->updateCategory($CategoryID, $CategoryAttributes);
    }

    public function deleteCategory($CategoryID)
    {
        return $this->CategoryRepository->deleteCategory($CategoryID);
    }
}
