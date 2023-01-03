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

        Pageviews::addMultiple($pageviews);

        Database::deletePageViews($lastId);

        return collect($pageviews)->sum();
    }
}
