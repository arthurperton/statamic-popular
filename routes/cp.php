<?php

use Illuminate\Support\Facades\Route;

Route::patch('/popular/pageviews/{id}', 'PageviewController@update');
