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

        [$updates, $lastId] = $result;

        if (! Pageviews::update($updates)) {
            return false;
        }
        
        $database->deletePageViews($lastId); // TODO what if this fails

        return count($updates);
    }
}
