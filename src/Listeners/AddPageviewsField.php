<?php

namespace ArthurPerton\Popular\Listeners;

use ArthurPerton\Popular\Facades\Config;
use Statamic\Entries\Collection;
use Statamic\Entries\Entry;
use Statamic\Events\EntryBlueprintFound;
use Statamic\Facades\User;

class AddPageviewsField
{
    public function handle(EntryBlueprintFound $event)
    {
        $user = User::current();

        if (! $user->can('view pageviews')) {
            return;
        }

        if (! $blueprint = $event->blueprint) {
            return;
        }

        if ($blueprint->hasField('pageviews')) {
            return;
        }

        if (! $collection = $this->getCollection($blueprint)) {
            return;
        }

        if (! Config::collectionIncluded($collection->handle())) {
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
                'type' => 'pageviews',
                'visibility' => 'computed',
                'editable' => $user->can('edit pageviews'),
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
