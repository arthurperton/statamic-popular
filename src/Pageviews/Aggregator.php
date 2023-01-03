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

        if (! Pageviews::addMultiple($pageviews)) {
            Log::debug('Aggregator: Error adding pageviews');
            return false; // TODO error/exception?
        }

        Database::deletePageViews($lastId); // TODO what if this fails

        return collect($pageviews)->sum();
    }
}
