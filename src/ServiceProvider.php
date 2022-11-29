<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use ArthurPerton\Statamic\Addons\Popular\Http\Middleware\UpdatePageviews;
use ArthurPerton\Statamic\Addons\Popular\Listeners\InjectPageViews;
use ArthurPerton\Statamic\Addons\Popular\Tags\Popular;
use Statamic\Facades\Collection;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        \Statamic\Events\CollectionSaved::class => [
            InjectPageViews::class,
        ],
        \Statamic\Events\CollectionUpdated::class => [
            InjectPageViews::class,
        ],
    ];

    protected $tags = [Popular::class];

    protected $middlewareGroups = ['web' => [UpdatePageviews::class]];

    public function bootAddon()
    {
        Statamic::afterInstalled(function ($command) {
            Collection::all()->each(function ($collection) {
                (new InjectPageViews())->handle((object) ['collection' => $collection]);
            });
        });
    }
}
