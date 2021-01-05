<?php

namespace App\Contracts;

interface CategoryRepositoryInterface
{

    public function paginateCategory();

    public function paginateCategoryBySearchingTerm(string $term);

    public function createCategory(array $CategoryAttributes);

    public function findOrFail(int $id);

    public function updateCategory(int $CategoryID, array $CategoryAttributes);

    public function deleteCategory($CategoryID);
}
