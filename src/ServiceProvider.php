<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use ArthurPerton\Statamic\Addons\Popular\Http\Middleware\Popular;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'web' => [
            Popular::class,
        ],
    ];
}
