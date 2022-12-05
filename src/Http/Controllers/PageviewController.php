<?php

namespace ArthurPerton\Popular\Http\Controllers;

use ArthurPerton\Popular\Pageviews\Database;
use Illuminate\Http\Request;

class PageviewController
{
    public function store(Request $request, Database $database)
    {
        $database->addPageview($request->post('entry'));
    }
}
