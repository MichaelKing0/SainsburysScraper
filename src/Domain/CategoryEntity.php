<?php

namespace MichaelKing0\SainsburysScraper\Domain;

/**
 * Class CategoryEntity
 * @package MichaelKing0\SainsburysScraper\Domain
 */
class CategoryEntity implements \JsonSerializable
{
    private $products = [];
    private $total = 0;

    /**
     * Get the products belonging to this category
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add a product entity to this category
     *
     * @param ProductEntity $result
     */
    public function addProduct(ProductEntity $result)
    {
        $this->products[] = $result;
        $this->updateTotal();
    }

    /**
     * Get the total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Update the total unit price of the products in this category
     */
    protected function updateTotal()
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->getUnitPrice();
        }

        $this->total = $total;
    }

    /**
     * Convert the object to json
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'results' => $this->products,
            'total' => number_format($this->getTotal(), 2)
        ];
    }
}