<?php

namespace ArthurPerton\Statamic\Addons\Popular\Listeners;

use Statamic\Events\EntryDeleted;

class DeletePageviews
{
    public function handle(EntryDeleted $event)
    {
        $id = $event->entry->id();

        // TODO delete pageviews for this entry.
    }
}
