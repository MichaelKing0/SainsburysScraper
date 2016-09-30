<?php

namespace MichaelKing0\SainsburysScraper\HtmlParser;

use MichaelKing0\SainsburysScraper\Domain\ProductEntity;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ProductParser
 * @package MichaelKing0\SainsburysScraper\HtmlParser
 */
class ProductParser
{
    /**
     * Get product entity from the crawler object
     *
     * @param Crawler $crawler
     * @param $size
     * @return ProductEntity
     */
    public function getProduct(Crawler $crawler, $size)
    {
        $title = trim($crawler->filter('.productTitleDescriptionContainer h1')->text());
        $unitPrice = trim($crawler->filter('.pricePerUnit')->text());
        $unitPrice = $this->filterPricePerUnit($unitPrice);
        $description = trim($crawler->filter('.productText')->text());

        return new ProductEntity($title, $size, $unitPrice, $description);
    }

    /**
     * Strip any non numeric characters and convert to float
     *
     * @param $pricePerUnit
     * @return float
     */
    private function filterPricePerUnit($pricePerUnit)
    {
        return (float)preg_replace('/[^0-9\.]/', '', $pricePerUnit);
    }
}