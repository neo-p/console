<?php

namespace NeoP\Console\Annotation\Handler;

use NeoP\Annotation\Annotation\Mapping\AnnotationHandler;
use NeoP\Console\Annotation\Mapping\Command;
use NeoP\Annotation\Annotation\Handler\Handler;
use NeoP\Console\Entity\Root;
use NeoP\Console\Commander;


use ReflectionClass;

/**
 * @AnnotationHandler(Command::class)
 */
class CommandHandler extends Handler
{
    public function handle(Command $annotation, ReflectionClass $reflectionClass)
    {
        $commander = $annotation->getCommand();
        $alias = $annotation->getAlias();

        if (! $commander) {
            return ;
        }

        if (! $alias) {
            $alias = $commander;
        }

        $describe = $annotation->getDescribe();
        Commander::setCommand($commander, new Root($commander, $this->className, $describe));
        Commander::setCommand($alias, new Root($alias, $this->className, $describe, true));
        Commander::setCommandHash($this->className, $commander);
        Commander::setCommandHash($this->className, $alias);
    }
}