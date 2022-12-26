<?php

namespace ArthurPerton\Popular\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string function path()
 * @method static bool exists(): bool
 * @method static void create($overwrite = false)
 * @method static void delete()
 * @method static void addPageview($entry, $timestamp = null)
 * @method static array getGroupedPageviews()
 * @method static void deletePageViews($lastId)
 * @method static void deletePageViewsForEntry($id)
 *
 * @see \ArthurPerton\Popular\Pageviews\Database
 */
class Database extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ArthurPerton\Popular\Pageviews\Database::class;
    }
}
