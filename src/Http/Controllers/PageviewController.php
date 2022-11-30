<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Controllers;

use Illuminate\Http\Request;


class PageviewController
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $url = $request->post('url');
    }

    public function createDatabase()
    {
    }
}
