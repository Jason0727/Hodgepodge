<?php

/**
 * 多例模式
 *
 * 定义:多例模式是指存在一个类有多个相同实例，而且该实例都是该类本身。这个类叫做多例类。
 *
 * 特点:
 * 1.多例类可以有多个实例
 * 2.多例类必须自己创建、管理自己的实例，并向外界提供自己的实例
 *
 * 说明:
 * 1.多例模式实际上就是单例模式的推广
 *
 * 应用:
 * 1.两个数据库连接器，比如一个是 MySQL ，另一个是 SQLite
 * 2.多个记录器（一个用于记录调试消息，一个用于记录错误）
 */

final class Multiton
{
    // 实例数组
    private static $instances = [];

    // 这里私有方法阻止用户随意的创建该对象实例
    private function __construct()
    {

    }

    public static function getInstance(string $instanceName): Multiton
    {
        if (!isset(self::$instances[$instanceName])) {
            self::$instances[$instanceName] = new self();
        }

        return self::$instances[$instanceName];
    }

    // 该私有对象阻止实例被克隆
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    // 该私有方法阻止实例被序列化
    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public function test()
    {
        return self::$instances;
    }
}

// 测试
var_dump(Multiton::getInstance("A")->test());
var_dump(Multiton::getInstance("B")->test());