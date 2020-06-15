<?php

namespace NeoP\Console\Entity;

class Option
{
    private $mapping;

    private $value;

    private $alias = false;
    
    private $describe = "";
    
    public function __construct(string $mapping, string $value = "", string $describe = "", bool $alias = false) {
        $this->setMapping($mapping);
        $this->setValue($value);
        $this->setDescribe($describe);
        $this->setAlias($alias);
    }

    public function setMapping(string $mapping)
    {
        $this->mapping = $mapping;
    }

    public function getMapping()
    {
        return $this->mapping;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setDescribe(string $describe)
    {
        $this->describe = $describe;
    }

    public function getDescribe()
    {
        return $this->describe;
    }

    public function setAlias(bool $alias)
    {
        $this->alias = $alias;
    }

    public function getAlias()
    {
        return $this->alias;
    }
}