<?php

namespace ArthurPerton\Statamic\Addons\Popular\Listeners;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Repository;
use Statamic\Events\EntryBlueprintFound;

class AddPageviewsField
{
    public function handle(EntryBlueprintFound $event)
    {
        if (!$blueprint = $event->blueprint) {
            return;
        }

        if (!$entry = $event->entry) {
            return;
        }

        // if ($blueprint->hasField('pageviews')) {
        //     return;
        // }

        if (!$blueprint->hasSection('sidebar')) {
            return;
        }

        $contents = $blueprint->contents();

        if (!isset($contents['sections']['sidebar']['fields'])) {
            $contents['sections']['sidebar']['fields'] = [];
        }

        $contents['sections']['sidebar']['fields'][] = [
            'handle' => 'pageviews',
            'field' => [
                'visibility' => 'read_only', // TODO make editable based on config?
            ],
        ];

        $blueprint->setContents($contents);

        $entry->set('pageviews', (new Repository)->get($entry->id()));
    }
}
