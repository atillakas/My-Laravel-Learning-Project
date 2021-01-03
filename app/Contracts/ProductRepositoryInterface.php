<?php

namespace App\Contracts;

interface ProductRepositoryInterface
{

    public function paginateProduct();

    public function paginateProductBySearchingTerm(string $term);

    public function createProduct(array $productAttributes);

    public function findOrFail(int $id);

    public function updateProduct(int $productID, array $productAttributes);

    public function deleteProduct($productID);
}
