<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    const MAX_SHOW_PAGE = 5;

    public function paginateProduct()
    {
        return Product::Paginate(self::MAX_SHOW_PAGE)->withQueryString();
    }

    public function paginateProductBySearchingTerm(string $term)
    {
        return Product::whereRaw("MATCH (name) AGAINST (? IN BOOLEAN MODE) OR MATCH (description) AGAINST (? IN BOOLEAN MODE)", array($term, $term))->Paginate(self::MAX_SHOW_PAGE)->withQueryString();
    }

    public function createProduct(array $productAttributes)
    {
        return Product::create($productAttributes);
    }

    public function findOrFail(int $id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(int $productID, array $productAttributes)
    {
        return Product::find($productID)->update($productAttributes);
    }

    public function deleteProduct($productID)
    {
        $product = Product::find($productID);
        if ($product != null) {
            return $product->delete();
        }
        return false;
    }
}
