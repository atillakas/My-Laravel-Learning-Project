<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    const MAX_SHOW_PAGE = 15;

    public function paginateCategory()
    {
        return Category::Paginate(self::MAX_SHOW_PAGE)->withQueryString();
    }

    public function paginateCategoryBySearchingTerm(string $term)
    {
        return Category::whereRaw("MATCH (name) AGAINST (? IN BOOLEAN MODE) OR MATCH (description) AGAINST (? IN BOOLEAN MODE)", array($term, $term))->Paginate(self::MAX_SHOW_PAGE)->withQueryString();
    }

    public function createCategory(array $CategoryAttributes)
    {
        return Category::create($CategoryAttributes);
    }

    public function findOrFail(int $id)
    {
        return Category::findOrFail($id);
    }

    public function updateCategory(int $CategoryID, array $CategoryAttributes)
    {
        return Category::find($CategoryID)->update($CategoryAttributes);
    }

    public function deleteCategory($CategoryID)
    {
        $Category = Category::find($CategoryID);
        if ($Category != null) {
            return $Category->delete();
        }
        return false;
    }
}
