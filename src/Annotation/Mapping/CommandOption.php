<?php

namespace NeoP\Console\Annotation\Mapping;

use NeoP\Annotation\Annotation\Mapping\AnnotationMappingInterface;

use function annotationBind;

/** 
 * @Annotation 
 */
final class CommandOption implements AnnotationMappingInterface
{
    private $option;

    private $alias = "";

    private $describe = "";

    function __construct($params)
    {
        annotationBind($this, $params, 'setOption');
    }

    public function setOption(string $option): void
    {
        $this->option = $option;
    }

    public function getOption(): string
    {
        return $this->option;
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
