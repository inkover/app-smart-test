<?php


namespace App\Models\OpenFood;


class ProductsList {

    /**
     * @var Product[]
     */
    private $items;

    /** @var int */
    private $total;

    /**
     * @return Product[]
     */
    public function getItems(): array {
        return $this->items;
    }

    /**
     * @param Product[] $items
     */
    public function setItems(array $items): void {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getTotal(): int {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void {
        $this->total = $total;
    }



}
