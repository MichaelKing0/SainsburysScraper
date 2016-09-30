<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use MichaelKing0\SainsburysScraper\Command\ScrapeCommand;
use Goutte\Client;
use MichaelKing0\SainsburysScraper\Service\CategoryService;
use MichaelKing0\SainsburysScraper\Scraper\Scraper;
use MichaelKing0\SainsburysScraper\HtmlParser\CategoryParser;
use MichaelKing0\SainsburysScraper\HtmlParser\ProductParser;

// @todo move this to a service container. Let's do this in this file for the time being...
$client = new Client();
$categoryService = new CategoryService(new Scraper($client), new CategoryParser(), new ProductParser());

$application = new Application();
$application->add(new ScrapeCommand($categoryService));
$application->run();