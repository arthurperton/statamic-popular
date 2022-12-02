<?php

namespace ArthurPerton\Statamic\Addons\Popular\Pageviews;

use ArthurPerton\Statamic\Addons\Popular\Facades\Pageviews;

class Aggregator
{
    public function aggregate(): bool
    {
        $database = new Database(); // TODO facade / inject?

        [$updates, $lastId] = $database->getGroupedPageviews();

        if ($success = Pageviews::update($updates)) {
            $database->deletePageViews($lastId);
        }

        return $success;
    }
}
