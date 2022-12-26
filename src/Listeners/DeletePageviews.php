<?php

namespace ArthurPerton\Popular\Listeners;

use ArthurPerton\Popular\Facades\Pageviews;
use ArthurPerton\Popular\Pageviews\Database;
use Statamic\Events\EntryDeleted;

class DeletePageviews
{
    public function handle(EntryDeleted $event)
    {
        $id = $event->entry->id();

        Pageviews::deleteMultiple([$id]);

        (app()->make(Database::class))->deletePageViewsForEntry($id);
    }
}
