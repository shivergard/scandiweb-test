<?php

/**
 * Collection of helper functions for framework
 */

use Sukonovs\Utilities\Dumper;

if (!function_exists('dd')) {

    /**
     * Die and dump
     *
     * @param mixed
     * @return void
     */
    function dd()
    {
        array_map(function ($x) {
            (new Dumper)->dump($x);
        }, func_get_args());
        die(1);
    }
}