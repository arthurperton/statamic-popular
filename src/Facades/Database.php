<?php

namespace ArthurPerton\Popular\Facades;

use ArthurPerton\Popular\Pageviews\Database as PageviewsDatabase;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool exists()
 * @method static void create(bool $overwrite = false)
 * @method static void delete()
 * @method static void addPageview(string $entry, int timestamp = null)
 * @method static null|[array, string] getGroupedPageviews()
 * @method static void deletePageViews(string $lastId)
 *
 * @see \ArthurPerton\Popular\Pageviews\Database
 */
class Database extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PageviewsDatabase::class;
    }
}
