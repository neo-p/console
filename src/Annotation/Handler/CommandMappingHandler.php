<?php

namespace NeoP\Console\Annotation\Handler;

use NeoP\Annotation\Annotation\Mapping\AnnotationHandler;
use NeoP\Console\Annotation\Mapping\CommandMapping;
use NeoP\Annotation\Annotation\Handler\Handler;

use NeoP\Console\Entity\Mapping;
use NeoP\Console\Commander;

use ReflectionMethod;

/**
 * @AnnotationHandler(CommandMapping::class)
 */
class CommandMappingHandler extends Handler
{
    public function handle(CommandMapping $annotation, ReflectionMethod $reflectionMethod)
    {
        
        $commanders = Commander::getCommandHash($this->className);
        foreach ($commanders as $commander) {
            if (Commander::commandExists($commander)) {
    
                $mapping = $annotation->getMapping();
                $alias = $annotation->getAlias();
                $methodName = $reflectionMethod->getName();
    
                if (! $mapping) {
                    $mapping = $methodName;
                }
                $describe = $annotation->getDescribe();
                Commander::getCommand($commander)->setMapping($mapping, new Mapping($mapping, $methodName, $describe));
                if($alias) {
                    Commander::getCommand($commander)->setMapping($alias, new Mapping($mapping, $methodName, $describe, true));
                }
            } else {
                throw new \Exception("Not found commander \"{$commander}\"!");
            }
        }
    }
}