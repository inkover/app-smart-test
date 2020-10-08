<?php


namespace App\Repositories;


use App\Models\OpenFood\Product;
use App\Models\OpenFood\ProductsList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenFoodListRepository {

    const CACHE_PREFIX_PRODUCT = 'product-';

    /**
     * @param int $page
     * @param int $perPage
     * @return ProductsList
     * @throws \Exception
     */
    public function getList(int $page, int $perPage = 20) : ProductsList {
        $result = $this->initList();
        $url = $this->initUrl($page, $perPage);
        $data = $this->download($url);
        $this->validateData($data);
        $result->setTotal($data['count']);
        $result->setItems($this->createItems($data));
        return $result;
    }

    /**
     * @param $originalProductId
     * @return Product|null
     */
    public function getFromCache($originalProductId) :? Product {
        return Cache::get(self::CACHE_PREFIX_PRODUCT . $originalProductId);
    }

    /**
     * @return ProductsList
     */
    protected function initList() {
        return new ProductsList();
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return string
     */
    protected function initUrl(int $page, int $perPage = 20) {
        return sprintf(
            'https://world.openfoodfacts.org/cgi/search.pl?action=process&sort_by=unique_scans_n&page=%d&page_size=%d&json=1',
            $page,
            $perPage
        );
    }

    /**
     * @param string $url
     * @return array|mixed
     */
    protected function download(string $url) {
        return Cache::remember('download-' . sha1($url), 600, function() use ($url){
            return Http::get($url)->json();
        });
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    protected function validateData(array &$data) {
        if (!isset($data['products'])) {
            throw new \Exception('No products found');
        }

        if (!isset($data['count'])) {
            throw new \Exception('No total count found');
        }

    }

    /**
     * @param array $data
     * @return Product[]
     */
    protected function createItems(array &$data) : array {
        $result = [];
        foreach ($data['products'] as $productData) {
            try {
                $this->validateProductData($productData);
            }
            catch (\Exception $e) {
                continue;
            }
            $product = $this->initProduct($productData);
            $this->cacheProduct($product);
            $result[] = $product;
        }
        return $result;
    }

    /**
     * @param array $productData
     * @return Product
     */
    protected function initProduct(array &$productData) : Product {
        return new Product(
            $productData['_id'],
            $productData['product_name'],
            $productData['image_url'] ?? '',
            $productData['categories'] ?? '',
        );
    }

    /**
     * @param array $productData
     * @throws \Exception
     */
    protected function validateProductData(array &$productData) {
        foreach (['_id', 'product_name', 'categories'] as $field) {
            if (!isset($productData[$field])) {
                throw new \Exception('Field \'' . $field . '\' is empty');
            }
        }
    }

    protected function cacheProduct(Product $product) {
        Cache::add(self::CACHE_PREFIX_PRODUCT . $product->getId(), $product, 600);
    }

}
