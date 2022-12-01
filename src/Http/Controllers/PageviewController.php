<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Controllers;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Database;
use Illuminate\Http\Request;

class PageviewController
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        // $url = $request->post('url');

        // \Log::debug($url);

        // $start = microtime(true);
        // $db = DB::connection('popular');

        // $db->insert('insert into pageviews (url, timestamp) values (?, ?)', [$url, time()]);
        // \Log::debug(microtime(true) - $start);

        (new Database)->addPageview($request->post('entry'));
    }
}
