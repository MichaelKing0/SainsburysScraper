<?php

namespace Tests\Domain;

use MichaelKing0\SainsburysScraper\Domain\ProductEntity;
use Tests\BaseTest;

class ProductEntityTest extends BaseTest
{
    /** @var ProductEntity */
    private $productEntity;

    public function setUp()
    {
        parent::setUp();
        $this->productEntity = new ProductEntity('Test title', '1kb', 1.50, 'Test description');
    }

    public function testGetTitle()
    {
        $this->assertEquals('Test title', $this->productEntity->getTitle());
    }

    public function getGetSize()
    {
        $this->assertEquals('1kb', $this->productEntity->getSize());
    }

    public function getUnitPrice()
    {
        $this->assertEquals(1.50, $this->productEntity->getUnitPrice());
    }

    public function getDescription()
    {
        $this->assertEquals('Test description', $this->productEntity->getDescription());
    }

    public function testSetTitle()
    {
        $this->productEntity->setTitle('Test title updated');
        $this->assertEquals('Test title updated', $this->getProperty($this->productEntity, 'title'));
    }

    public function testSetSize()
    {
        $this->productEntity->setSize('2kb');
        $this->assertEquals('2kb', $this->getProperty($this->productEntity, 'size'));
    }

    public function testSetUnitPrice()
    {
        $this->productEntity->setUnitPrice(2);
        $this->assertEquals(2, $this->getProperty($this->productEntity, 'unitPrice'));
    }

    public function testSetDescription()
    {
        $this->productEntity->setDescription('Test description updated');
        $this->assertEquals('Test description updated', $this->getProperty($this->productEntity, 'description'));
    }
}