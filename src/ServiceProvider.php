<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use ArthurPerton\Statamic\Addons\Popular\Config\Config;
use ArthurPerton\Statamic\Addons\Popular\Facades\Pageviews;
use ArthurPerton\Statamic\Addons\Popular\Facades\Database;
use Statamic\Facades\Collection;
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
        Tags\PopularPageviews::class,
        Tags\PopularScript::class,
    ];

    protected $commands = [
        Console\Commands\CreateDatabase::class,
        Console\Commands\Aggregate::class,
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    public function bootAddon()
    {
        $this->handleConfig();
        // $this->addDatabaseConnection();
        $this->createComputedValues();

        Statamic::afterInstalled(function () {
            Database::create(); // database will only be created if it doesn't exist yet
        });
    }

    protected function handleConfig()
    {
        // TODO test merging
        $this->mergeConfigFrom(__DIR__ . '/../config/popular.php', 'popular');

        $this->publishes([
            __DIR__ . '/../config/popular.php' => config_path('popular.php'),
        ], 'popular-config');
    }

    // protected function addDatabaseConnection()
    // {
    //     config(['database.connections.popular' => [
    //         'driver' => 'sqlite',
    //         'database' => Database::path(),
    //     ]]);
    // }

    protected function createComputedValues()
    {
        Collection::handles()->each(function ($handle) {
            if (!(new Config)->includeCollection($handle)) return;

            Collection::computed($handle, 'pageviews', function ($entry) {
                return Pageviews::get($entry->id());
            });
        });
    }

    protected function schedule($schedule)
    {
        $schedule->command('popular:aggregate')->everyMinute();
    }
}
