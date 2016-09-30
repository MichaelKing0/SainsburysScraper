<?php

namespace Tests\Command;


use MichaelKing0\SainsburysScraper\Command\ScrapeCommand;
use MichaelKing0\SainsburysScraper\Domain\CategoryEntity;
use MichaelKing0\SainsburysScraper\Domain\ProductEntity;
use Symfony\Component\Console\Output\ConsoleOutput;
use Tests\BaseTest;

class ScrapeCommandTest extends BaseTest
{
    /** @var ScrapeCommand */
    private $scrapeCommand;

    public function setUp()
    {
        parent::setUp();

        $categoryEntity = new CategoryEntity();
        $categoryEntity->addProduct(new ProductEntity('Test title', '100kb', 1, 'Test description'));
        $categoryEntity->addProduct(new ProductEntity('Test title', '100kb', 1, 'Test description'));

        $categoryServiceMock = \Mockery::mock('MichaelKing0\SainsburysScraper\Service\CategoryService', function($mock) use ($categoryEntity){
            $mock->shouldReceive('getCategory')->andReturn($categoryEntity);
        });

        $this->scrapeCommand = new ScrapeCommand($categoryServiceMock);
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testExecute()
    {
        $inputMock = \Mockery::mock('Symfony\Component\Console\Input\InputInterface', function($mock){
            $mock->shouldReceive('getArgument')->once()->andReturn('http://www.test.com');
            $mock->shouldReceive('getOption')->once()->andReturn('0');
        });

        $outputMock = \Mockery::mock('Symfony\Component\Console\Output\OutputInterface', function($mock){
            $mock->shouldReceive('writeln')->withArgs([file_get_contents(__DIR__ . '/Data/ExpectedTestData.json')]);
        });

        $this->invokeMethod($this->scrapeCommand, 'execute', [$inputMock, $outputMock]);
    }
}