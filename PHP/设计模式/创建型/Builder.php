<?php

/**
 * 建造者模式
 *
 * 定义:将一个复杂对象的构建与它的表示分离，使得同样的构建过程可以创建不同的表示。
 * PS:类似于变形金刚，相同的零件进行不同的组合
 */

// 构建Builder接口，规范建造标准
interface BuilderInterface
{
    public function createVehicle();

    public function addWheel();

    public function addEngine();

    public function addDoors();

    public function getVehicle(): Vehicle;
}

/**
 * Director 类是建造者模式的一部分。 它可以实现建造者模式的接口
 * 并在构建器的帮助下构建一个复杂的对象
 *
 * 您也可以注入许多构建器而不是构建更复杂的对象
 */
class Director
{
    public function build(BuilderInterface $builder): Vehicle
    {
        $builder->createVehicle();
        $builder->addWheel();
        $builder->addEngine();
        $builder->addDoors();

        return $builder->getVehicle();
    }
}

// 卡车建造者
class TruckBuilder implements BuilderInterface
{
    private $truck;

    public function createVehicle()
    {
        $this->truck = new Truck();
    }

    public function addWheel()
    {
        $this->truck->setPart('wheel1', new Wheel());
        $this->truck->setPart('wheel2', new Wheel());
        $this->truck->setPart('wheel3', new Wheel());
        $this->truck->setPart('wheel4', new Wheel());
        $this->truck->setPart('wheel5', new Wheel());
        $this->truck->setPart('wheel6', new Wheel());
    }

    public function addEngine()
    {
        $this->truck->setPart('truckEngine', new Engine());
    }

    public function addDoors()
    {
        $this->truck->setPart('rightDoor', new Door());
        $this->truck->setPart('leftDoor', new Door());
    }

    public function getVehicle(): Vehicle
    {
        return $this->truck;
    }
}

// 汽车建造者
class CarBuilder implements BuilderInterface
{
    private $car;

    public function createVehicle()
    {
        $this->car = new Car();
    }

    public function addWheel()
    {
        $this->car->setPart('wheelLF', new Wheel());
        $this->car->setPart('wheelRF', new Wheel());
        $this->car->setPart('wheelLR', new Wheel());
        $this->car->setPart('wheelRR', new Wheel());
    }

    public function addEngine()
    {
        $this->car->setPart('CarEngine', new Engine());
    }

    public function addDoors()
    {
        $this->car->setPart('rightDoor', new Door());
        $this->car->setPart('leftDoor', new Door());
        $this->car->setPart('trunkLid', new Door());
    }

    public function getVehicle(): Vehicle
    {
        return $this->car;
    }
}

// 卡车类
class Truck extends Vehicle
{

}

// 汽车类
class Car extends Vehicle
{
}

// 交通工具抽象类
abstract class Vehicle
{
    private $data = [];

    public function setPart($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getData()
    {
        return $this->data;
    }
}

// 引擎类
class Engine
{
}

// 轮子类
class Wheel
{
}

// 门类
class Door
{
}

// 测试
class DirectorTest extends \PHPUnit\Framework\TestCase
{
    public function testCanBuildTruck()
    {
        $trunkBuilder = new TruckBuilder();
        $newVehicle = (new Director())->build($trunkBuilder);

        $this->assertInstanceOf(Truck::class, $newVehicle);
    }

    public function testCanBuildCar()
    {
        $carBuilder = new CarBuilder();
        $newVehicle = (new Director())->build($carBuilder);

        $this->assertInstanceOf(Car::class, $newVehicle);
    }
}