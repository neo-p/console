<?php

namespace NeoP\Console\Entity;

class Mapping
{
    private $mapping;
    
    private $methodName;
    
    private $alias;
    
    private $describe = "";

    public function __construct(string $mapping, string $methodName, string $describe = "", bool $alias = false) {
        $this->setMapping($mapping);
        $this->setMethodName($methodName);
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

    public function setMethodName(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function getMethodName()
    {
        return $this->methodName;
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