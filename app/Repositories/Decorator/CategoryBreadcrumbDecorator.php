<?php

namespace App\Repositories\Decorator;


use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;


class CategoryBreadcrumbDecorator implements CategoryRepositoryInterface
{

    private $categoryRepository;

    private $categoryModel;

    public function __construct(CategoryRepositoryInterface $categoryRepository, Category $categoryModel)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryModel = $categoryModel;
    }

    public function allCategories()
    {
        //attention : there are heavy query for breadcrumb
        $allCategory = $this->categoryRepository->allCategories();
        $allCategory->map(function ($item) {
            $result = $this->categoryModel->defaultOrder()->ancestorsAndSelf($item->id)->toArray();
            $item->name = implode(' &#11162; ', array_column($result, "name"));
            return $item;
        });
        return $allCategory;
    }

    public function orWhereNotDescendantOf($id)
    {
        //attention : there are heavy query for breadcrumb
        $descendantCategories = $this->categoryRepository->orWhereNotDescendantOf($id);
        $descendantCategories->map(function ($item) {
            $result = $this->categoryModel->defaultOrder()->ancestorsAndSelf($item->id)->toArray();
            $item->name = implode(' &#11162; ', array_column($result, "name"));
            return $item;
        });
        return $descendantCategories;
    }

    public function paginateCategory()
    {
        $paginate =  $this->categoryRepository->paginateCategory();
        $paginate->getCollection()->map(function ($item) {
            $result = $this->categoryModel->defaultOrder()->ancestorsAndSelf($item->id)->toArray();
            $item->name = implode(' &#11162; ', array_column($result, "name"));
            return $item;
        });
        return $paginate;
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
        return $this->categoryRepository->findOrFail($id);
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
