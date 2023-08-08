<?php

use ArthurPerton\Popular\Http\Controllers\PageviewController;
use Illuminate\Support\Facades\Route;

Route::post('/!/popular/pageviews', [PageviewController::class, 'store']);
