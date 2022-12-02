<?php

namespace ArthurPerton\Statamic\Addons\Popular\Listeners;

use Statamic\Events\EntryBlueprintFound;

class AddPageviewsField
{
    public function handle(EntryBlueprintFound $event)
    {
        if (!$blueprint = $event->blueprint) {
            return;
        }

        if ($blueprint->hasField('pageviews')) {
            return;
        }

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
                'visibility' => 'computed',
            ],
        ];

        $blueprint->setContents($contents);
    }
}
