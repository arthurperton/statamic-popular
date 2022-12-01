<?php

namespace ArthurPerton\Statamic\Addons\Popular\Tags;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Repository;
use Statamic\Tags\Collection\Entries as EntriesBase;

class Entries extends EntriesBase
{
    protected function results($query)
    {
        $repository = new Repository();

        return parent::results($query)->map(function ($entry) use ($repository) {
            return $entry->setSupplement('pageviews', $repository->get($entry->id()));
        });
    }
}
