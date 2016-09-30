<?php

namespace Tests\HtmlParser;

use MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser;
use MichaelKing0\SainsburysScraper\HtmlParser\ProductParser;
use Symfony\Component\DomCrawler\Crawler;
use Tests\BaseTest;

class ProductParserTest extends BaseTest
{
    /** @var ProductParser */
    private $productParser;

    public function setUp()
    {
        parent::setUp();
        $this->productParser = new ProductParser();
    }

    public function testGetProduct()
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent(file_get_contents(__DIR__ . '/Data/TestProduct.html'));
        $product = $this->productParser->getProduct($crawler, '100kb');

        $this->assertInstanceOf('MichaelKing0\SainsburysScraper\Domain\ProductEntity', $product);
        $this->assertEquals('Sainsbury\'s Apricot Ripe & Ready x5', $product->getTitle());
        $this->assertEquals(3.5, $product->getUnitPrice());
        $this->assertEquals('100kb', $product->getSize());
        $this->assertEquals('Apricots', $product->getDescription());
    }

    public function testFilterPricePerUnit()
    {
        $this->assertEquals(1.5, $this->invokeMethod($this->productParser, 'filterPricePerUnit', ['£1.50']));
    }
}