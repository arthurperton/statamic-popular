<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Controllers;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Database;
use Illuminate\Http\Request;

class PageviewController
{
    public function store(Request $request, Database $database)
    {
        $database->addPageview($request->post('entry'));
    }
}
