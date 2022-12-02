<?php

namespace ArthurPerton\Statamic\Addons\Popular\Pageviews;

use ArthurPerton\Statamic\Addons\Popular\Facades\Database;
use ArthurPerton\Statamic\Addons\Popular\Facades\Pageviews;

class Aggregator
{
    public function aggregate(): bool
    {
        $result = Database::getGroupedPageviews();
        if (! $result) {
            return false;
        }

        [$updates, $lastId] = $result;

        if ($success = Pageviews::update($updates)) {
            Database::deletePageViews($lastId);
        }

        return $success;
    }
}
