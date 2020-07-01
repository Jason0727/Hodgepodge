<?php

use PHPUnit\Framework\TestCase;

/**
 * 抽象工厂模式
 *
 * 定义:在不指定具体类的情况下，创建一系列相关或依赖的对象。通常创建的类都实现相同的接口。抽象工厂的客户并不关心这些对象如何创建，它只是知道他们是如何一起运行的。
 */
interface Product
{
    public function calculatePrice(): int;
}

class ShippableProduct implements Product
{
    private $productPrice;

    private $shippingCosts;

    public function __construct(int $productPrice, int $shippingCosts)
    {
        $this->productPrice = $productPrice;
        $this->shippingCosts = $shippingCosts;
    }

    public function calculatePrice(): int
    {
        return $this->productPrice + $this->shippingCosts;
    }
}

class DigitalProduct implements Product
{
    private $price;

    public function __construct(int $price)
    {
        $this->price = $price;
    }

    public function calculatePrice(): int
    {
        return $this->price;
    }
}

class ProductFactory
{
    const SHIPPING_COSTS = 50;

    public function createShippableProduct(int $price): Product
    {
        return new ShippableProduct($price, self::SHIPPING_COSTS);
    }

    public function createDigitalProduct(int $price): Product
    {
        return new DigitalProduct($price);
    }
}

class AbstractFactoryTest extends TestCase
{
    public function testCanCreateDigitalProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createDigitalProduct(150);
        $this->assertInstanceOf(DigitalProduct::class, $product);
    }

    public function testCanCreateShippableProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createShippableProduct(150);
        $this->assertInstanceOf(ShippableProduct::class, $product);
    }

    public function testCanCalculatePriceForDigitalProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createDigitalProduct(150);
        $this->assertEquals(150, $product->calculatePrice());
    }

    public function testCanCalculatePriceForShippableProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createShippableProduct(150);
        $this->assertEquals(200, $product->calculatePrice());
    }
}