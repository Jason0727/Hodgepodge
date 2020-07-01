<?php

/**
 * 原型模式
 *
 * 目的:相比正常创建一个对象 (new Foo () )，首先创建一个原型，然后克隆它会更节省开销。
 */

abstract class BookPrototype
{
    protected $title;

    protected $category;

    abstract public function __clone();

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}

class BarBookPrototype extends BookPrototype
{
    protected $category = "Bar";

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }
}

class FooBookPrototype extends BookPrototype
{
    protected $category = "Foo";

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }
}

// 测试
class PrototypeTest extends \PHPUnit\Framework\TestCase
{
    public function testCanGetFooBook()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->name = '123123';

        $obj2 = clone $obj;
        $obj2->id = 2;
        var_dump($obj2);
        die();

        $barPrototype = new BarBookPrototype();
        $fooPrototype = new FooBookPrototype();
        for ($i = 0; $i < 10; $i++) {
            $book = clone $fooPrototype;
            $book->setTitle('Foo Book No ' . $i);
            $this->assertInstanceOf(FooBookPrototype::class, $book);
        }
    }
}