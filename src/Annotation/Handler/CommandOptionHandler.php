<?php

namespace NeoP\Console\Annotation\Handler;

use NeoP\Annotation\Annotation\Mapping\AnnotationHandler;
use NeoP\Console\Annotation\Mapping\CommandOption;
use NeoP\Annotation\Annotation\Handler\Handler;
use NeoP\Console\Commander;
use NeoP\Console\Entity\Option;
use ReflectionMethod;

/**
 * @AnnotationHandler(CommandOption::class)
 */
class CommandOptionHandler extends Handler
{
    public function handle(CommandOption $annotation, ReflectionMethod $reflectionMethod)
    {
        $option = $annotation->getOption();
        $methodName = $reflectionMethod->getName();
        $alias = $annotation->getAlias();
        if (! $option) {
            $option = $methodName;
        }
        $describe = $annotation->getDescribe();
        Commander::setOptionHash($option, $this->className);
        Commander::setOption(new Option($option, $methodName, $describe));
        if ($alias != NULL) {
            Commander::setOptionHash($alias, $this->className);
            Commander::setOption(new Option($alias, $methodName, $describe, true));
        }
    }
}
