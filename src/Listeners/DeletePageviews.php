<?php

namespace ArthurPerton\Popular\Listeners;

use ArthurPerton\Popular\Facades\Database;
use ArthurPerton\Popular\Facades\Pageviews;
use Statamic\Events\EntryDeleted;

class DeletePageviews
{
    public function handle(EntryDeleted $event)
    {
        $id = $event->entry->id();

        Pageviews::deleteMultiple([$id]);

        Database::deletePageViewsForEntry($id);
    }
}
