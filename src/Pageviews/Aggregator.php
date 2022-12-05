<?php

namespace ArthurPerton\Popular\Pageviews;

use ArthurPerton\Popular\Facades\Pageviews;

class Aggregator
{
    public function aggregate(): bool
    {
        $database = app(Database::class); // TODO try injection

        $result = $database->getGroupedPageviews();
        if (! $result) {
            return false;
        }

        [$updates, $lastId] = $result;

        if ($success = Pageviews::update($updates)) {
            $database->deletePageViews($lastId); // TODO what if this fails
        }

        return $success;
    }
}
