<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository {

    public function findOrCreateCategories(array $categoryNames) {
        $result = [];
        foreach ($categoryNames as $categoryName) {
            $result[] = Category::query()->firstOrCreate(['name' => $categoryName], ['name' => $categoryName]);

        }
        return $result;
    }

}
