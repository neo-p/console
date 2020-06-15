<?php

namespace NeoP\Console\Entity;

use NeoP\Console\Entity\Option;

class Command
{
    private $commander;

    private $mapping;
    
    private $options = [];

    public function setCommander(string $commander)
    {
        $this->commander = $commander;
    }

    public function getCommander()
    {
        return $this->commander;
    }
    
    public function setMapping(string $mapping)
    {
        $this->mapping = $mapping;
    }

    public function getMapping()
    {
        return $this->mapping;
    }

    public function setOption(Option $option)
    {
        $this->options[$option->getMapping()] = $option;
    }

    public function getOption(string $mapping)
    {
        return $this->options[$mapping];
    }

    public function getOptions()
    {
        return $this->options;
    }
}