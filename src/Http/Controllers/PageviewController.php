<?php

namespace ArthurPerton\Popular\Http\Controllers;

use ArthurPerton\Popular\Facades\Pageviews;
use ArthurPerton\Popular\Pageviews\Database;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;

class PageviewController extends CpController
{
    public function store(Request $request, Database $database)
    {
        $json = $request->getContent();

        $data = json_decode($json);

        if ($entry = $data->entry ?? null) {
            $database->addPageview($entry);
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
