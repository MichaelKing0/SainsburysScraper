<?php

namespace Tests\HtmlParser;

use MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser;
use Symfony\Component\DomCrawler\Crawler;
use Tests\BaseTest;

class CategoryParserTest extends BaseTest
{
    /** @var CategoryParser */
    private $categoryParser;

    public function setUp()
    {
        parent::setUp();
        $this->categoryParser = new CategoryParser();
    }

    public function testGetProductUrls()
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent(file_get_contents(__DIR__ . '/Data/TestCategory.html'));
        $urls = $this->categoryParser->getProductUrls($crawler);

        $this->assertInternalType('array', $urls);
        $this->assertEquals([
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado--ripe---ready-x2.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocados--ripe---ready-x4.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-golden-kiwi--taste-the-difference-x4-685641-p-44.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-kiwi-fruit--ripe---ready-x4.html",
        ], $urls);
    }
}