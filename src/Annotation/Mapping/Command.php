<?php

namespace NeoP\Console\Annotation\Mapping;

use NeoP\Annotation\Annotation\Mapping\AnnotationMappingInterface;

use function annotationBind;

/** 
 * @Annotation 
 */
final class Command implements AnnotationMappingInterface
{
    private $command = "";

    private $alias = "";
    
    private $describe = "";

    function __construct($params)
    {
        annotationBind($this, $params, 'setCommand');
    }

    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
    
    public function setDescribe(string $describe)
    {
        $this->describe = $describe;
    }

    public function getDescribe()
    {
        return $this->describe;
    }
}