<?php

namespace NeoP\Console\Entity;

use NeoP\Console\Entity\Mapping;

class Root
{
    private $commander;
    
    private $className;

    private $alias;

    private $mappings = [];

    private $describe = "";

    public function __construct(string $commander, string $className, string $describe = "", bool $alias = false) {
        $this->setCommander($commander);
        $this->setClassName($className);
        $this->setDescribe($describe);
        $this->setAlias($alias);
    }

    public function setCommander(string $commander)
    {
        $this->commander = $commander;
    }

    public function getCommander()
    {
        return $this->commander;
    }

    public function setClassName(string $className)
    {
        $this->className = $className;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function setMapping(string $methodName, Mapping $mapping)
    {
        $this->mappings[$methodName] = $mapping;
    }

    public function getMapping(string $methodName)
    {
        return $this->mappings[$methodName];
    }

    public function hasMapping(string $methodName)
    {
        return isset($this->mappings[$methodName]);
    }

    public function getMappings()
    {
        return $this->mappings;
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