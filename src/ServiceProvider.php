<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Database;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
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
            // Collection::all()->each(function ($collection) {
            //     (new Listeners\InjectPageViews())->handle((object) ['collection' => $collection]);
            // });
            (new Database)->create(); // TODO or create if it doesn't exists?
        });

        config(['database.connections.popular' => [
            'driver' => 'sqlite',
            'database' => database_path('app/popular.sqlite'),
        ]]);
    }

    protected function schedule($schedule)
    {
        $schedule->command('popular:aggregate')->everyMinute();
    }
}
