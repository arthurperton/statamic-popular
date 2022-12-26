<?php

namespace ArthurPerton\Popular\Http\Controllers;

use ArthurPerton\Popular\Facades\Database;
use ArthurPerton\Popular\Facades\Pageviews;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;

class PageviewController extends CpController
{
    public function store(Request $request)
    {
        if ($entry = $request->entry ?? null) {
            Database::addPageview($entry);
        }
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('edit pageviews');

        $request->validate([
            'views' => 'required|integer',
        ]);

        Pageviews::setMultiple([$id => $request->views]);
    }
}
