<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use Statamic\Facades\Collection;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        \Statamic\Events\CollectionSaved::class => [
            Listeners\InjectPageViews::class,
        ],
        \Statamic\Events\CollectionUpdated::class => [
            Listeners\InjectPageViews::class,
        ],
        \Statamic\Events\EntryBlueprintFound::class => [
            Listeners\AddPageviewsField::class,
        ],
    ];

    protected $tags = [
        Tags\Popular::class,
    ];

    protected $commands = [
        Console\Commands\CreateDatabase::class,
    ];

    public function bootAddon()
    {
        Statamic::afterInstalled(function ($command) {
            Collection::all()->each(function ($collection) {
                (new Listeners\InjectPageViews())->handle((object) ['collection' => $collection]);
            });
        });
    }
}
