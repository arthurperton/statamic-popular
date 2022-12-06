<?php

namespace ArthurPerton\Popular\Http\Controllers;

use ArthurPerton\Popular\Pageviews\Database;
use Illuminate\Http\Request;

class PageviewController
{
    public function store(Request $request, Database $database)
    {
        $json = $request->getContent();

        $data = json_decode($json);

        if ($entry = $data->entry ?? null) {
            $database->addPageview($entry);
        }
    }
}
