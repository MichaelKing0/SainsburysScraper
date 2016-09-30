<?php

namespace Tests\Domain;

use MichaelKing0\SainsburysScraper\Domain\CategoryEntity;
use MichaelKing0\SainsburysScraper\Domain\ProductEntity;
use Tests\BaseTest;

class CategoryEntityTest extends BaseTest
{
    /** @var CategoryEntity */
    private $categoryEntity;

    public function setUp()
    {
        parent::setUp();
        $this->categoryEntity = new CategoryEntity();

        $this->setProperty($this->categoryEntity, 'products', $this->getProductFixtures());
        $this->setProperty($this->categoryEntity, 'total', 4);
    }

    private function getProductFixtures()
    {
        return [
            new ProductEntity('Test title', '1kb', 1.50, 'Test description'),
            new ProductEntity('Test title 2', '2kb', 2.50, 'Test description 2'),
        ];
    }

    public function testGetProductsWithEmpty()
    {
        // prepare the test
        $this->setProperty($this->categoryEntity, 'products', []);

        // run the test
        $result = $this->categoryEntity->getProducts();
        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    public function testGetProducts()
    {
        $result = $this->categoryEntity->getProducts();
        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
    }

    public function testAddProduct()
    {
        $this->categoryEntity->addProduct(new ProductEntity('Test title 3', '3kb', 1, 'Test description 3'));
        $this->assertCount(3, $this->getProperty($this->categoryEntity, 'products'));
        $this->assertEquals(5, $this->getProperty($this->categoryEntity, 'total'));
    }

    public function testUpdateTotal()
    {
        // prepare the test
        $this->setProperty($this->categoryEntity, 'products', array_merge($this->getProductFixtures(), $this->getProductFixtures()));

        // run the test
        $this->invokeMethod($this->categoryEntity, 'updateTotal');
        $this->assertEquals(8, $this->categoryEntity->getTotal());
    }

    public function testJsonSerialize()
    {
        $json = json_encode($this->categoryEntity);
        $this->assertEquals(
            '{"results":[{"title":"Test title","size":"1kb","unitPrice":"1.50","description":"Test description"},{"title":"Test title 2","size":"2kb","unitPrice":"2.50","description":"Test description 2"}],"total":"4.00"}',
            $json
        );
    }
}