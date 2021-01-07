<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    const MAX_SHOW_PAGE = 15;

    public function allCategories()
    {
        return Category::All();
    }

    public function orWhereNotDescendantOf($id)
    {
        $node = Category::find($id);
        return Category::orWhereNotDescendantOf($node)->get();
    }

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
        $node = Category::find($CategoryID); //Find which node will be deleted
        $parent_id = $node->parent_id; //Get node of parent_id that will be delete
        $findNextChildren = Category::where("parent_id", $node->id); //Find children nodes
        $findNextChildren->update(['parent_id' => $parent_id]); //Assign node of parent id to children nodes of  parent id
        Category::fixTree(); //Attention : Before deleting the node, you must fix the table otherwise all child nodes will be deleted with together main node.

        //Find the same node, that node's disconnected with the children nodes anymore you can delete safely.
        $nodeDelete = Category::find($CategoryID);
        $nodeDelete->delete();

        //Fix the table again against the broken
        if (Category::isBroken()) {
            Category::fixTree();
            return false;
        }
        return true;
    }
}
