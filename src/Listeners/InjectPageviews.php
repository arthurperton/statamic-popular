<?php

namespace ArthurPerton\Statamic\Addons\Popular\Listeners;

class InjectPageViews
{
    public function handle($event)
    {
        if (! $collection = $event->collection) {
            return;
        }

        $cascade = $collection->cascade();

        if (! $cascade->has('pageviews')) {
            $collection->cascade($cascade->put('pageviews', 0)->all())->save();
        }
    }
}
