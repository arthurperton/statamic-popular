<?php

namespace ArthurPerton\Statamic\Addons\Popular\Pageviews;

class Aggregator
{
    public function aggregate(): bool
    {
        $database = new Database(); // TODO facade / inject?

        [$updates, $lastId] = $database->getGroupedPageviews();

        // dd($updates);

        $repository = new Repository(); // TODO facade

        if ($success = $repository->update($updates)) {
            $database->deletePageViews($lastId);
        }

        return $success;
    }
}
