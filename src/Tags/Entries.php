<?php

namespace ArthurPerton\Statamic\Addons\Popular\Tags;

use Statamic\Tags\Collection\Entries as EntriesBase;

class Entries extends EntriesBase
{
    protected function results($query)
    {
        return parent::results($query)->map(function ($entry) {
            // if (! $entry->get('pageviews')) {
            //     $entry->set('pageviews', 0);
            // }

            return $entry;
        });
    }
}
