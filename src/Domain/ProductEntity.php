<?php

namespace MichaelKing0\SainsburysScraper\Domain;

/**
 * Class ProductEntity
 * @package MichaelKing0\SainsburysScraper\Domain
 */
class ProductEntity implements \JsonSerializable
{
    private $title;
    private $size;
    private $unitPrice;
    private $description;

    /**
     * ProductEntity constructor.
     * @param $title
     * @param $size
     * @param $unitPrice
     * @param $description
     */
    public function __construct($title, $size, $unitPrice, $description)
    {
        $this->setTitle($title);
        $this->setSize($size);
        $this->setUnitPrice($unitPrice);
        $this->setDescription($description);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param mixed $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'size' => $this->getSize(),
            'unitPrice' => number_format($this->getUnitPrice(), 2),
            'description' => $this->getDescription(),
        ];
    }
}