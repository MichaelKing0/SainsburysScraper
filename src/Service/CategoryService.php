<?php

namespace MichaelKing0\SainsburysScraper\Service;

use Goutte\Client;
use MichaelKing0\SainsburysScraper\Domain\CategoryEntity;
use MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser;
use MichaelKing0\SainsburysScraper\HtmlParser\ProductParser;
use MichaelKing0\SainsburysScraper\Scraper\Scraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CategoryService
 * @package MichaelKing0\SainsburysScraper\Service
 */
class CategoryService
{
    private $scraper;
    private $categoryParser;
    private $productParser;

    /**
     * CategoryService constructor.
     * @param Scraper $scraper
     * @param CategoryParser $categoryParser
     * @param ProductParser $productParser
     */
    public function __construct(Scraper $scraper, CategoryParser $categoryParser, ProductParser $productParser)
    {
        $this->scraper = $scraper;
        $this->categoryParser = $categoryParser;
        $this->productParser = $productParser;
    }

    /**
     * Get a category entity from a URL
     *
     * @param $url
     * @return CategoryEntity
     */
    public function getCategory($url)
    {
        $crawler = $this->scraper->makeRequest($url)->getCrawler();
        $productUrls = $this->getProductUrls($crawler);

        $category = new CategoryEntity();

        foreach ($productUrls as $productUrl) {
            $category->addProduct($this->getProduct($productUrl));
        }

        return $category;
    }

    /**
     * Get product URLs from a crawler object
     *
     * @param $crawler
     * @return array
     */
    private function getProductUrls(Crawler $crawler)
    {
        return $this->categoryParser->getProductUrls($crawler);
    }

    /**
     * Get a product entity from a URL
     *
     * @param $productUrl
     * @return \MichaelKing0\SainsburysScraper\Domain\ProductEntity
     */
    private function getProduct($productUrl)
    {
        $this->scraper->makeRequest($productUrl);
        $size = $this->scraper->getPageSize(Scraper::FORMAT_KB);
        return $this->productParser->getProduct($this->scraper->getCrawler(), $size);
    }
}