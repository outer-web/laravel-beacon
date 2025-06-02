<?php

namespace Outerweb\Beacon\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Outerweb\Beacon\Beacon
 */
class Beacon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Outerweb\Beacon\Beacon::class;
    }
}
