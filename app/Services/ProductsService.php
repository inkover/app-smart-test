<?php


namespace App\Services;


use App\Models\OpenFood\ProductsList;
use App\Models\Product;
use App\Models\OpenFood\Product as OpenFoodProduct;
use App\Repositories\CategoryRepository;
use App\Repositories\OpenFoodListRepository;
use App\Repositories\ProductRepository;

class ProductsService {

    /** @var OpenFoodListRepository */
    private $openFoodRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var ProductRepository */
    private $productRepository;

    /**
     * ProductsService constructor.
     *
     * @param OpenFoodListRepository $openFoodRepository
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(OpenFoodListRepository $openFoodRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository) {
        $this->openFoodRepository = $openFoodRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }


    /**
     * @param int $page
     * @param int $perPage
     * @return ProductsList
     * @throws \Exception
     */
    public function getOpenFoodList(int $page, int $perPage = 20): ProductsList {
        return $this->openFoodRepository->getList($page, $perPage);
    }

    /**
     * @param string $originalId
     * @throws \Exception
     */
    public function storeProduct(string $originalId) {
        $openFoodProduct = $this->openFoodRepository->getFromCache($originalId);
        if (! $openFoodProduct instanceof OpenFoodProduct) {
            throw new \Exception('Cached product not found. Please refresh page');
        }
        $product = $this->productRepository->findByOriginalId($originalId);
        $categories = $this->categoryRepository->findOrCreateCategories($openFoodProduct->getCategoriesArray());
        $this->productRepository->updateProductFromOpenFood($product, $openFoodProduct, $categories);
    }

}
