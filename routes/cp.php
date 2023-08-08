<?php

use ArthurPerton\Popular\Http\Controllers\PageviewController;
use Illuminate\Support\Facades\Route;

Route::patch('/popular/pageviews/{id}', [PageviewController::class, 'update']);
