<?php


namespace App\Models\OpenFood;


class Product {

    private $id;
    private $name;
    private $imageUrl;
    private $categories;

    /**
     * Product constructor.
     *
     * @param $id
     * @param $name
     * @param $imageUrl
     * @param $categories
     */
    public function __construct($id, $name, $imageUrl, $categories) {
        $this->id         = $id;
        $this->name       = $name;
        $this->imageUrl  = $imageUrl;
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getImageUrl() {
        return $this->imageUrl;
    }

    /**
     * @return mixed
     */
    public function getCategories() {
        return $this->categories;
    }

    public function getCategoriesArray() {
        $result = explode(',', $this->categories);
        $result = array_map('trim', $result);
        $result = array_filter($result);
        return $result;
    }


}
