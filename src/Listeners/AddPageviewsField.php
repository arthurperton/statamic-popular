<?php

namespace ArthurPerton\Popular\Listeners;

use ArthurPerton\Popular\Config\Config;
use Statamic\Entries\Collection;
use Statamic\Entries\Entry;
use Statamic\Events\EntryBlueprintFound;

class AddPageviewsField
{
    public function handle(EntryBlueprintFound $event)
    {
        if (! $blueprint = $event->blueprint) {
            return;
        }

        if ($blueprint->hasField('pageviews')) {
            return;
        }

        if (! $collection = $this->getCollection($blueprint)) {
            return;
        }

        if (! (new Config)->includeCollection($collection->handle())) {
            return;
        }

        // TODO change this sidebar logic. Field should at least always show on
        // the list view.
        if (! $blueprint->hasSection('sidebar')) {
            return;
        }

        $contents = $blueprint->contents();

        if (! isset($contents['sections']['sidebar']['fields'])) {
            $contents['sections']['sidebar']['fields'] = [];
        }

        $contents['sections']['sidebar']['fields'][] = [
            'handle' => 'pageviews',
            'field' => [
                'visibility' => 'computed',
            ],
        ];

        $blueprint->setContents($contents);
    }

    private function getCollection($blueprint)
    {
        $parent = $blueprint->parent();

        if ($parent instanceof Entry) {
            return $parent->collection();
        } elseif ($parent instanceof Collection) {
            return $parent;
        } else {
            return null;
        }
    }
}
