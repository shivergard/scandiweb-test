<?php

namespace Sukonovs\Utilities;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * Var dumper class
 *
 * @author Roberts Sukonovs <roberts@efumo.lv>
 */
class Dumper
{
    /**
     * Dump variable
     *
     * @see http://symfony.com/doc/current/components/var_dumper/advanced.html
     *
     * @param mixed
     * @return void
     */
    public function dump($var)
    {
        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        $dumper->dump((new VarCloner())->cloneVar($var));
    }
}