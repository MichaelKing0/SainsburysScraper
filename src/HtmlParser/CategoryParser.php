<?php

namespace MichaelKing0\SainsburysScraper\HtmlParser;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CategoryParser
 * @package MichaelKing0\SainsburysScraper\HtmlParser
 */
class CategoryParser
{
    /**
     * Get the product URLs from a crawler object
     *
     * @param Crawler $crawler
     * @return array
     */
    public function getProductUrls(Crawler $crawler)
    {
        return $crawler->filter('#productsContainer .productLister li')->each(function(Crawler $crawler) {
            return $crawler->filter('a')->attr('href');
        });
    }
}