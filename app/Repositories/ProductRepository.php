<?php


namespace App\Repositories;


use App\Models\Category;
use App\Models\Product;
use App\Models\OpenFood\Product as OpenFoodProduct;

class ProductRepository {

    /**
     * @param $originalId
     * @return Product|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function findByOriginalId($originalId) {
        $result = Product::query()->firstWhere('original_id', $originalId);
        if (! $result instanceof Product) {
            $result = new Product();
        }
        return $result;
    }

    /**
     * @param Product $product
     * @param OpenFoodProduct $openFoodProduct
     * @param array|Category[] $categories
     */
    public function updateProductFromOpenFood(Product $product, OpenFoodProduct $openFoodProduct, array $categories) {
        $product->name      = $openFoodProduct->getName();
        $product->image_url = $openFoodProduct->getImageUrl();
        $product->original_id = $openFoodProduct->getId();
        $product->save();

        $product->categories()->detach();

        foreach ($categories as $category) {
            $product->categories()->save($category);
        }
    }

}
