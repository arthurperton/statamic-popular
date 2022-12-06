<?php

namespace ArthurPerton\Popular\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool collectionIncluded(string $handle)
 *
 * @see \ArthurPerton\Popular\Config\Config
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ArthurPerton\Popular\Config\Config::class;
    }
}
