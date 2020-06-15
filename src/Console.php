<?php

namespace NeoP\Console;

use NeoP\Console\Entity\Root;
use NeoP\Log\Log;

class Console
{

    private $command;

    public static function init()
    {
        $instance = new static();
        $instance->command = Commander::getCurrentCommand();
        return $instance;
    }

    public function help()
    {
        $this->beforeOut();
        if ($this->command->getCommander() != NULL) {
            $this->stdoutMapping($this->command->getCommander());
        } else {
            $this->stdoutCommand();
        }
        $this->optionsOut();
        $this->afterOut();
        $this->Exit();
    }

    public function beforeOut()
    {
        $commandTip = "{command}:{mapping}";
        if ($this->command->getCommander()) {
            $commandTip = $this->command->getCommander() . ':' . ($this->command->getMapping() ?? '{mapping}');
        }
        
        Log::stdout("Command list:", 0, Log::MODE_UNDERLINE, Log::FG_WHITE);
        Log::stdout("");
        Log::stdout("Usage: ", 1, Log::MODE_DEFAULT, Log::FG_WHITE);
        Log::stdout('php bin/{app} ' . $commandTip . ' [-options1 -options2 -options3 ...]', 2, Log::MODE_DEFAULT, Log::FG_FUCHSIA);
        Log::stdout("Tips:\tThe {app} is your application.", 1, Log::MODE_DEFAULT);
        Log::stdout("if you need multi service you can create copy default service {app} and modify it.", 2, Log::MODE_DEFAULT);
        Log::stdout("");
        Log::stdout("Command: ", 1, Log::MODE_DEFAULT, Log::FG_WHITE);
    }

    public function afterOut()
    {
        Log::stdout("");
        Log::stdout("");
        Log::stdout("ERROR:", 0, Log::MODE_DEFAULT, Log::FG_RED);
        Log::stdout("Please enter the correct command!", 1, Log::MODE_DEFAULT, Log::FG_RED);
        Log::stdout("");
    }

    public function optionsOut()
    {
        Log::stdout("");
        Log::stdout("Global Options: ", 1, Log::MODE_DEFAULT, Log::FG_WHITE);
        $options = Commander::getOptions();
        $data = [];
        $nameLength = 0;
        $aliasLength = 0;
        foreach ($options as $option) {
            if ($option->getAlias()) {
                $data[$option->getValue()]['alias'] = $option->getMapping();
                $currentAliasLength = strlen($option->getMapping());
                if ($aliasLength < $currentAliasLength) {
                    $aliasLength = $currentAliasLength;
                }
            } else {
                $data[$option->getValue()]['name'] = $option->getMapping();
                $data[$option->getValue()]['describe'] = $option->getDescribe();
                $currentNameLength = strlen($option->getMapping());
                if ($nameLength < $currentNameLength) {
                    $nameLength = $currentNameLength;
                }
            }
        }
        $this->stdoutArrayLine($data, $nameLength, $aliasLength, 2, '-');
    }

    public function stdoutCommand()
    {
        $commands = Commander::getCommands();
        $data = [];
        $nameLength = 0;
        $aliasLength = 0;
        foreach ($commands as $key => $command) {
            if ($command->getAlias()) {
                $data[$command->getClassName()]['alias'] = $command->getCommander();
                $currentAliasLength = strlen($command->getCommander());
                if ($aliasLength < $currentAliasLength) {
                    $aliasLength = $currentAliasLength;
                }
            } else {
                $data[$command->getClassName()]['name'] = $command->getCommander();
                $currentNameLength = strlen($command->getCommander());
                if ($nameLength < $currentNameLength) {
                    $nameLength = $currentNameLength;
                }
                $data[$command->getClassName()]['describe'] = $command->getDescribe();
            }
        }
        $this->stdoutArrayLine($data, $nameLength, $aliasLength, 2);
    }

    public function stdoutArrayLine(array $datas, int $nameLength, int $aliasLength, int $tab = 0, string $limiter = "")
    {
        $limiterLength = \strlen($limiter);
        $nameLength += $limiterLength;
        $aliasLength += $limiterLength;
        foreach ($datas as $data) {
            $tip = isset($data['describe']) && ! empty($data['describe']) ? "\tTip: " . $data['describe'] : '';
            if (isset($data['alias']) && ! empty($data['alias'])) {
                $alias = $limiter . $data['alias'];
                $alias = "\t/ "  . str_pad($alias, $aliasLength);
            } else {
                $alias = "\t";
            }
            $name = $limiter . $data['name'];
            $name = str_pad($name, $nameLength);
            Log::stdout($name . $alias . $tip, $tab, Log::MODE_DEFAULT);
        }
    }

    public function stdoutMapping(string $commander)
    {
        Log::stdout($commander, 2, Log::MODE_DEFAULT);
        $command = Commander::getCommand($commander);
        
        $data = [];
        $nameLength = 0;
        $aliasLength = 0;
        foreach ($command->getMappings() as $mapping) {
            if ($mapping->getAlias()) {
                $data[$mapping->getMethodName()]['alias'] = $mapping->getMapping();
                $currentAliasLength = strlen($mapping->getMapping());
                if ($aliasLength < $currentAliasLength) {
                    $aliasLength = $currentAliasLength;
                }
            } else {
                $data[$mapping->getMethodName()]['name'] = $mapping->getMapping();
                $data[$mapping->getMethodName()]['describe'] = $mapping->getDescribe();
                $currentNameLength = strlen($mapping->getMapping());
                if ($nameLength < $currentNameLength) {
                    $nameLength = $currentNameLength;
                }
            }
        }
        $this->stdoutArrayLine($data, $nameLength, $aliasLength, 3, ':');
    }

    public function Exit()
    {
        Log::stdout("          _____________", 0, Log::MODE_DEFAULT, Log::FG_RED);
        Log::stdout("---------| NEO-P EXIT! |---------", 0, Log::MODE_DEFAULT, Log::FG_RED);
        Log::stdout("          ￣￣￣￣￣￣￣", 0, Log::MODE_DEFAULT, Log::FG_RED);
        Log::stdout("");
        exit;
    }

}