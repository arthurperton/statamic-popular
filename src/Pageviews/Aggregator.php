<?php

namespace ArthurPerton\Popular\Pageviews;

use ArthurPerton\Popular\Facades\Pageviews;

class Aggregator
{
    public function aggregate(): int|false
    {
        $database = app(Database::class);

        $result = $database->getGroupedPageviews();
        if (! $result) {
            return 0;
        }

        [$pageviews, $lastId] = $result;

        if (! Pageviews::addMultiple($pageviews)) {
            return false; // TODO error/exception?
        }

        $database->deletePageViews($lastId); // TODO what if this fails

        return collect($pageviews)->sum();
    }
}
