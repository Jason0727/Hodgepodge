<?php

/**
 * 工厂方法模式
 *
 * 定义:将类的实例化延迟到工厂类的子类中完成，即由子类来决定应该实例化哪个类
 */

// 定义Logger接口
interface Logger
{
    public function log(string $message);
}

// Stdout接口实现类
class StdoutLogger implements Logger
{
    public function log(string $message)
    {
        echo "Stdout_" . $message;
    }
}

// File接口实现类
class FileLogger implements Logger
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $message)
    {
        echo "File_" . $this->filePath . "_" . $message;
    }
}

// 定义Logger工厂接口
interface LoggerFactory
{
    public function createLogger(): Logger;
}

// StdoutLogger工厂实现类
class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): Logger
    {
        return new StdoutLogger();
    }
}

// FileLogger工厂实现类
class FileLoggerFactory implements LoggerFactory
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function createLogger(): Logger
    {
        return new FileLogger($this->filePath);
    }
}

// 测试
class FactoryMethodTest extends \PHPUnit\Framework\TestCase
{
    public function testCanCreateStdoutLogging()
    {
        $loggerFactory = new StdoutLoggerFactory();
        $logger = $loggerFactory->createLogger();

        $this->assertInstanceOf(StdoutLogger::class, $logger);
    }

    public function testCanCreateFileLogging()
    {
        $loggerFactory = new FileLoggerFactory(sys_get_temp_dir());
        $logger = $loggerFactory->createLogger();
        $this->assertInstanceOf(FileLogger::class, $logger);
    }
}