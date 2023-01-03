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
        if (!$user = User::current()) {
            return;
        }

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

        $contents = $blueprint->contents();

        if (! ($contents['sections'] ?? null)) {
            return;
        }

        $section = isset($contents['sections']['sidebar']) ? 'sidebar' : array_key_first($contents['sections']);

        if (! isset($contents['sections'][$section]['fields'])) {
            $contents['sections'][$section]['fields'] = [];
        }

        $contents['sections'][$section]['fields'][] = [
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
