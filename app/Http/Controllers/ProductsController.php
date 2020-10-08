<?php

namespace App\Http\Controllers;

use App\Services\ProductsService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{
    const PER_PAGE = 10;

    public function list(Request $request, ProductsService $productsService) {
        $currentPage = $request->input('page', 1);
        $perPage = self::PER_PAGE;

        try {
            $list = $productsService->getOpenFoodList($currentPage);
        }
        catch (\Exception $e) {
            return 'ERROR: ' . $e->getMessage();
        }

        $paginator = new LengthAwarePaginator($list->getItems(), $list->getTotal(), $perPage, $currentPage, ['path' => 'products']);
        return view('list', [
            'paginator' => $paginator
        ]);
    }

    public function store(ProductsService $productsService, $productId) {
        $productsService->storeProduct($productId);
    }

}
