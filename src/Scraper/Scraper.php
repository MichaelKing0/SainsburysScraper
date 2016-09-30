<?php

namespace MichaelKing0\SainsburysScraper\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Scraper
 * @package MichaelKing0\SainsburysScraper\Scraper
 */
class Scraper
{
    protected $client;
    /** @var Crawler */
    protected $crawler;

    const FORMAT_KB = 'kb';
    const FORMAT_MB = 'mb';

    /**
     * Scraper constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a request, and store the crawler
     *
     * @param $url
     * @param string $method
     * @param array $parameters
     * @return $this
     */
    public function makeRequest($url, $method = 'GET', $parameters = [])
    {
        $this->crawler = $this->client->request($method, $url, $parameters);
        return $this;
    }

    /**
     * Get a crawler object from the request
     *
     * @return Crawler
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * Get the page size in a particular format
     *
     * @param $format
     * @param int $roundingPrecision
     * @return string
     */
    public function getPageSize($format, $roundingPrecision = 2)
    {
        $bytes = $this->getBytes();

        if ($format == static::FORMAT_KB) {
            return number_format($bytes / 1024, $roundingPrecision) . 'kb';
        }

        if ($format == static::FORMAT_MB) {
            return number_format($bytes / 1024 / 1024, $roundingPrecision) . 'mb';
        }

        throw new \InvalidArgumentException('Format is not valid.');
    }

    /**
     * Get the page size in bytes
     *
     * @return int
     */
    private function getBytes()
    {
        return strlen($this->client->getInternalResponse()->getContent());
    }
}