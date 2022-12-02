<?php

namespace ArthurPerton\Statamic\Addons\Popular\Facades;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Repository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int get(string $entry)
 * @method static \Illuminate\Support\Collection all()
 * @method static bool update(array $updates)
 *
 * @see \ArthurPerton\Statamic\Addons\Popular\Pageviews\Repository
 */
class Pageviews extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}
