<?php

namespace ArthurPerton\Popular\Pageviews;

use ArthurPerton\Popular\Facades\Database;
use ArthurPerton\Popular\Facades\Pageviews;
use Illuminate\Support\Facades\Log;

class Aggregator
{
    public function aggregate(): int|false
    {
        $result = Database::getGroupedPageviews();
        if (! $result) {
            Log::debug('Aggregator: No pageviews found');
            return 0;
        }

        [$pageviews, $lastId] = $result;

        Pageviews::addMultiple($pageviews);

        Database::deletePageViews($lastId);

        return collect($pageviews)->sum();
    }
}
