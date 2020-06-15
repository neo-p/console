<?php

namespace NeoP\Console\Annotation\Mapping;

use NeoP\Annotation\Annotation\Mapping\AnnotationMappingInterface;

use function annotationBind;

/** 
 * @Annotation 
 */
final class CommandMapping implements AnnotationMappingInterface
{
    private $mapping;

    private $alias = "";

    private $describe = "";
    
    function __construct($params)
    {
        annotationBind($this, $params, 'setMapping');
    }

    public function setMapping(string $mapping): void
    {
        $this->mapping = $mapping;
    }

    public function getMapping(): string
    {
        return $this->mapping;
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