<?php

namespace Tests\Scraper;

use Goutte\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MichaelKing0\SainsburysScraper\Scraper\Scraper;
use Tests\BaseTest;

class ScraperTest extends BaseTest
{
    /** @var Scraper */
    private $scraper;

    public function setUp()
    {
        parent::setUp();

        $mockHandler = new MockHandler([
            new Response(200, [], '<html><body>Test response</body></html>'),
        ]);

        $handler = HandlerStack::create($mockHandler);
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);
        $client = new Client();
        $client->setClient($guzzle);

        $this->scraper = new Scraper($client);
    }

    public function testMakeRequest()
    {
        $this->scraper->makeRequest('test-url');
        $this->assertEquals('Test response', $this->getProperty($this->scraper, 'crawler')->filter('body')->text());
    }

    public function testGetCrawler()
    {
        $this->scraper->makeRequest('test-url');
        $this->assertInstanceOf('Symfony\Component\DomCrawler\Crawler', $this->scraper->getCrawler());
    }

    public function testGetPageSizeInKb()
    {
        $this->scraper->makeRequest('test-url');
        $this->assertEquals('0.04kb', $this->scraper->getPageSize(Scraper::FORMAT_KB));
    }

    public function testGetPageSizeInMb()
    {
        $this->scraper->makeRequest('test-url');
        $this->assertEquals('0.00003719329833984375mb', $this->scraper->getPageSize(Scraper::FORMAT_MB, 20));
    }
}