<?php

namespace Statamic\Addons\Popularity;

use Statamic\Addons\Popularity\Http\Middleware\Popularity;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'web' => [
            Popularity::class
        ],
    ];
}
