<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/!/popular', 'as' => 'popular.'], function () {
    Route::post('/pageviews', 'PageviewController@store')->withoutMiddleware('App\Http\Middleware\VerifyCsrfToken');
});
