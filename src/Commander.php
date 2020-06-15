<?php

namespace NeoP\Console;

use NeoP\DI\Container;
use NeoP\DI\InjectType;

use NeoP\Console\Entity\Root;
use NeoP\Console\Entity\Command;
use NeoP\Console\Entity\Option;
use NeoP\Console\Exception\CommandException;
use ReflectionMethod;

class Commander
{
    private static $commands = [];
    private static $optionHash = [];
    private static $options = [];
    private static $commandHash = [];
    private static $command;
    
    const COMMAND_SEPARATOR = ":";
    const OPTION_SEPARATOR = "-";

    public static function init() {
        self::parseCommand();
        Commander::execOptions();
    }

    private static function parseCommand()
    {
        $argv = $GLOBALS['argv'];
        // 去除命令中的执行文件
        array_shift($argv);
        $command = new Command();
        $haveCommand = FALSE;
        $haveOptions = FALSE;
        $commander = null;
        $mapping = null;
        foreach ($argv as $value) {
            if (strpos($value, self::OPTION_SEPARATOR) === 0) {
                $option = substr($value, 1);
                $command->setOption(new Option($option[0]));
                $haveOptions = TRUE;
            } elseif ($mapping == null) {
                $commands = explode(self::COMMAND_SEPARATOR, $value);
                if (isset($commands[0]) && ! empty($commands[0])) {
                    $commander = $commands[0];
                    $haveCommand = TRUE;
                    if (isset($commands[1]) && ! empty($commands[1])) {
                        $mapping = $commands[1];
                    }
                }
            }
        }

        if ($commander != null)
            $command->setCommander($commander);
        if ($mapping != null)
            $command->setMapping($mapping);
        self::$command = $command;
        if (! $haveCommand && ! $haveOptions) {
            Console::init()->help();
        }
    }

    public static function getCall(): array
    {
        $isExec = FALSE;
        // 判断是否存在启动命令
        $callback = NULL;
        $argv = [];
        if (! self::$command->getCommander() || ! self::$command->getMapping() ) {
            Console::init()->help();
        }
        if (self::hasCommand(self::$command->getCommander())) {
            $command = self::getCommand(self::$command->getCommander());
            $class = self::getCommand(self::$command->getCommander())->getClassName();
            $object = Container::getClassObject($class,  InjectType::getInjectType($class));
            // 查看mapping是否存在 存在则调用方法
            // 不存在则匹配查询
            if ($command->hasMapping(self::$command->getMapping())) {
                $method = $command->getMapping(self::$command->getMapping())->getMethodName();
                $reflectionMethod = new ReflectionMethod($class, $method) ;
                $callback = $reflectionMethod->getClosure($object);
                $isExec = TRUE;
            } else {
                $mappings = $command->getMappings();
                foreach ($mappings as $key => $mapping) {
                    if (preg_match('/^\$\{\w.+\}$/', $mapping->getMapping())) {
                        try {
                            $method = self::$command->getMapping();
                            $reflectionMethod = new ReflectionMethod($class, $method);
                            $argv[] = $method;
                            $callback = $reflectionMethod->getClosure($object);
                            $isExec = TRUE;
                        } catch (CommandException $e) {
                            echo "not exists ". self::$command->getMapping() ." method for class " . $class . " Error Message: " .$e->getMessage()."\n";
                        }
                    }
                }
            }
        }
        if (! $isExec) {
            throw new CommandException("Error Command ". self::$command->getCommander() .":". self::$command->getMapping() . ", Please check if the command exists.", 1);
        }
        return [$callback, $argv];
    }

    public static function execOptions()
    {
        $execOptions = self::$command->getOptions();
        foreach ($execOptions as $execOption) {
            if (self::hasOption($execOption->getMapping())) {
                $option = self::getOption($execOption->getMapping());
                $class = self::$optionHash[$option->getMapping()];
                $object = Container::getClassObject($class, InjectType::getInjectType($class));
                $method = $option->getValue();
                $object->{$method}();
            }
        }
    }

    public static function setCommandHash(string $hash, string $commander) {
        self::$commandHash[$hash][] = $commander;
    }

    public static function getCommandHash(string $hash) {
        return self::$commandHash[$hash];
    }

    public static function setCommand(string $key, Root $root) {
        self::$commands[$key] = $root;
    }

    public static function commandExists(string $key) {
        if (isset(self::$commands[$key])) {
            return true;
        }
        return false;
    }

    public static function getCommand(string $key) {
        return self::$commands[$key];
    }

    public static function hasCommand(string $key) {
        return isset(self::$commands[$key]);
    }

    public static function getCommands() {
        return self::$commands;
    }

    public static function setOptionHash(string $hash, string $option)
    {
        self::$optionHash[$hash] = $option;
    }

    public static function getOptionHash(string $hash)
    {
        return self::$optionHash[$hash];
    }

    public static function setOption(Option $option)
    {
        self::$options[$option->getMapping()] = $option;
    }

    public static function optionExists(string $key)
    {
        if (isset(self::$options[$key])) {
            return true;
        }
        return false;
    }

    public static function getOption(string $key)
    {
        return self::$options[$key];
    }

    public static function hasOption(string $key)
    {
        return isset(self::$options[$key]);
    }

    public static function getOptions()
    {
        return self::$options;
    }

    public static function getCurrentCommand()
    {
        return self::$command;
    }
    
}