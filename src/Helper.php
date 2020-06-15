<?php

namespace NeoP\Console;

use NeoP\Console\Annotation\Mapping\Command;
use NeoP\Console\Annotation\Mapping\CommandOption;
use NeoP\Console\Console;

/**
 * @Command()
 */
class Helper
{

    /**
     * @CommandOption("help", alias="h", describe="Print help documents.")
     */
    public function help()
    {
        Console::init()->help();
    }
}
