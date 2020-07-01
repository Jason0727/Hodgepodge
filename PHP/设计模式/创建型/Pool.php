<?php

/**
 * 对象池模式
 *
 * 定义:对象池可以用于构造并且存放一系列的对象并在需要时获取调用。在初始化实例成本高，实例化率高，可用实例不足的情况下，对象池可以极大地提升性能。在创建对象（尤其是通过网络）时间花销不确定的情况下，通过对象池在短期时间内就可以获得所需的对象
 *
 * 特点:
 * 1.对象池模式是一种提前准备了一组已经初始化了的对象『池』而不是按需创建或者销毁的创建型设计模式
 * 2.对象池的客户端会向对象池中请求一个对象，然后使用这个返回的对象执行相关操作
 * 3.在初始化实例成本高，实例化率高，可用实例不足的情况下，对象池可以极大地提升性能。在创建对象（尤其是通过网络）时间花销不确定的情况下，通过对象池在可期时间内就可以获得所需的对象。
 * 4.对象池模式在需要耗时创建对象方面，例如创建数据库连接，套接字连接，线程和大型图形对象（比方字体或位图等），使用起来都是大有裨益的。在某些情况下，简单的对象池（无外部资源，只占内存）可能效率不高，甚至会有损性能
 */

class WorkerPool implements Countable
{
    private $occupiedWorkers = [];

    private $freeWorkers = [];

    public function count(): int
    {
        return count($this->occupiedWorkers) + count($this->freeWorkers);
    }

    public function get()
    {
        if (count($this->freeWorkers) == 0) {
            $worker = new StringReverseWorker();
        } else {
            $worker = array_pop($this->freeWorkers);
        }

        $this->occupiedWorkers[spl_object_hash($worker)] = $worker;

        return $worker;
    }

    public function dispose(StringReverseWorker $worker)
    {
        $key = spl_object_hash($worker);
        if (isset($this->occupiedWorkers[$key])) {
            unset($this->occupiedWorkers[$key]);
            $this->freeWorkers[$key] = $worker;
        }
    }

}

class StringReverseWorker
{
    public function run(string $text)
    {
        return strrev($text);
    }
}

// 测试
class PoolTest extends \PHPUnit\Framework\TestCase
{
    public function testCanGetNewInstancesWithGet()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $worker2 = $pool->get();

        $this->assertCount(2, $pool);
        $this->assertNotSame($worker1, $worker2);
    }

    public function testCanGetSameInstanceTwiceWhenDisposingItFirst()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();

        $this->assertCount(1, $pool);
        $this->assertSame($worker1, $worker2);
    }
}