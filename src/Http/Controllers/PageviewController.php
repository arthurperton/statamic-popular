<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageviewController
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $url = $request->post('url');

        \Log::debug($url);

        $start = microtime(true);
        $db = DB::connection('popular');

        $db->insert('insert into pageviews (url, timestamp) values (?, ?)', [$url, time()]);
        \Log::debug(microtime(true) - $start);
    }
}
