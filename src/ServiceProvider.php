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
        \Statamic\Events\EntryDeleted::class => [
            Listeners\DeletePageviews::class,
        ],
    ];

    protected $tags = [
        Tags\Popular::class,
    ];

    protected $commands = [
        Console\Commands\CreateDatabase::class,
        Console\Commands\Aggregate::class,
    ];

    // protected $scripts = [
    //     __DIR__ . '/../resources/js/popular.js',
    // ];
    protected $publishables = [
        __DIR__ . '/../resources/js' => 'js',
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    public function bootAddon()
    {
        Statamic::afterInstalled(function ($command) {
            Collection::all()->each(function ($collection) {
                (new Listeners\InjectPageViews())->handle((object) ['collection' => $collection]);
            });
        });

        config(['database.connections.popular' => [
            'driver' => 'sqlite',
            'database' => database_path('app/popular.sqlite'),
        ]]);
    }
}
