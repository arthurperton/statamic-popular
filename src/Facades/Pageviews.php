<?php

namespace ArthurPerton\Popular\Facades;

use ArthurPerton\Popular\Pageviews\Repository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int get(string $entry)
 * @method static \Illuminate\Support\Collection all()
 * @method static bool addMultiple(array $updates)
 * @method static bool setMultiple(array $updates)
 *
 * @see \ArthurPerton\Popular\Pageviews\Repository
 */
class Pageviews extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}
