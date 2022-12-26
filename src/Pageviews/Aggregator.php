<?php

namespace ArthurPerton\Popular\Pageviews;

use ArthurPerton\Popular\Facades\Database;
use ArthurPerton\Popular\Facades\Pageviews;

class Aggregator
{
    public function aggregate(): int|false
    {
        $result = Database::getGroupedPageviews();
        if (! $result) {
            return 0;
        }

        [$pageviews, $lastId] = $result;

        if (! Pageviews::addMultiple($pageviews)) {
            return false; // TODO error/exception?
        }

        Database::deletePageViews($lastId); // TODO what if this fails

        return collect($pageviews)->sum();
    }
}
