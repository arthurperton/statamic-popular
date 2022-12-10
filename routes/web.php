<?php

use Illuminate\Support\Facades\Route;

Route::post('/!/popular/pageviews', 'PageviewController@store')
    ->withoutMiddleware('App\Http\Middleware\VerifyCsrfToken');
