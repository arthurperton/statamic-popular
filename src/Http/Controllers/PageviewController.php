<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Controllers;

use ArthurPerton\Statamic\Addons\Popular\Facades\Database;
use Illuminate\Http\Request;

class PageviewController
{
    public function store(Request $request)
    {
        Database::addPageview($request->post('entry'));
    }
}
