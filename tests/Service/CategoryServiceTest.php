<?php

namespace Tests\Service;

use MichaelKing0\SainsburysScraper\Domain\ProductEntity;
use MichaelKing0\SainsburysScraper\Service\CategoryService;
use Mockery\Mock;
use Symfony\Component\DomCrawler\Crawler;
use Tests\BaseTest;

class CategoryServiceTest extends BaseTest
{
    /** @var CategoryService */
    private $categoryService;

    public function tearDown()
    {
        \Mockery::close();
    }

    public function testGetCategory()
    {
        // set up test
        $scraperMock = \Mockery::mock('MichaelKing0\SainsburysScraper\Scraper\Scraper', function($mock){
            $mock->shouldReceive('makeRequest')->times(3)->andReturn($mock);
            $mock->shouldReceive('getPageSize')->times(2)->andReturn('100kb');
            $mock->shouldReceive('getCrawler')->times(3)->andReturn(new Crawler());
        });
        $categoryParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser', function($mock){
            $mock->shouldReceive('getProductUrls')->times(1)->andReturn(['http://www.test.com', 'http://www.test2.com']);
        });
        $productParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\ProductParser', function($mock){
            $mock->shouldReceive('getProduct')->times(2)->andReturn(new ProductEntity('Test title', '100kb', 1.5, 'Test description'));
        });

        $this->categoryService = new CategoryService($scraperMock, $categoryParserMock, $productParserMock);

        // run test
        $category = $this->categoryService->getCategory('http://www.test.com');
        $this->assertInstanceOf('MichaelKing0\SainsburysScraper\Domain\CategoryEntity', $category);
        $this->assertCount(2, $category->getProducts());
        $this->assertEquals(3, $category->getTotal());
    }

    public function testGetProductUrls()
    {
        // set up test
        $scraperMock = \Mockery::mock('MichaelKing0\SainsburysScraper\Scraper\Scraper');
        $categoryParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser', function($mock){
            $mock->shouldReceive('getProductUrls')->times(1)->andReturn(['http://www.test.com', 'http://www.test2.com']);
        });
        $productParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\ProductParser');

        $this->categoryService = new CategoryService($scraperMock, $categoryParserMock, $productParserMock);

        // run test
        $productUrls = $this->invokeMethod($this->categoryService, 'getProductUrls', [new Crawler()]);
        $this->assertInternalType('array', $productUrls);
        $this->assertCount(2, $productUrls);
    }

    public function testGetProductDto()
    {
        // set up test
        $scraperMock = \Mockery::mock('MichaelKing0\SainsburysScraper\Scraper\Scraper', function($mock){
            $mock->shouldReceive('makeRequest')->times(1)->andReturn($mock);
            $mock->shouldReceive('getPageSize')->times(1)->andReturn('100kb');
            $mock->shouldReceive('getCrawler')->times(1)->andReturn(new Crawler());
        });
        $categoryParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser');
        $productParserMock = \Mockery::mock('MichaelKing0\SainsburysScraper\HtmlParser\ProductParser', function($mock){
            $mock->shouldReceive('getProduct')->times(1)->andReturn(new ProductEntity('Test title', '100kb', 1.5, 'Test description'));
        });

        $this->categoryService = new CategoryService($scraperMock, $categoryParserMock, $productParserMock);

        // run test
        $product = $this->invokeMethod($this->categoryService, 'getProduct', [new Crawler(), '100kb']);
        $this->assertInstanceOf('MichaelKing0\SainsburysScraper\Domain\ProductEntity', $product);
    }
}