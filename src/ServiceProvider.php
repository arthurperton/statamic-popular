<?php

namespace ArthurPerton\Statamic\Addons\Popular;

use ArthurPerton\Statamic\Addons\Popular\Config\Config;
use ArthurPerton\Statamic\Addons\Popular\Facades\Pageviews;
use ArthurPerton\Statamic\Addons\Popular\Pageviews\Database;
use Statamic\Facades\Collection;
use Statamic\Providers\AddonServiceProvider;

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

    protected $widgets = [
        Widgets\MostPopular::class,
    ];

    protected $commands = [
        Console\Commands\CreateDatabase::class,
        Console\Commands\Aggregate::class,
        Console\Commands\Stress::class,
    ];

    protected $routes = [
        'web' => __DIR__.'/../routes/web.php',
    ];

    public function register()
    {
        $this->app->singleton(Database::class, function () {
            return new Database();
        });
    }

    // public function boot()
    // {
    //     $this->handleConfig();

    //     parent::boot();
    // }

    public function bootAddon()
    {
        $this->createComputedValues();

        // Statamic::afterInstalled(function () {
        //$this->app->make(Database::class)->create(); // database will only be created if it doesn't exist yet
        // });
    }

    // protected function handleConfig()
    // {
    //     // TODO test merging
    //     $this->mergeConfigFrom(__DIR__.'/../config/popular.php', 'popular');

    //     $this->publishes([
    //         __DIR__.'/../config/popular.php' => config_path('popular.php'),
    //     ], 'popular-config');
    // }

    protected function createComputedValues()
    {
        Collection::handles()->each(function ($handle) {
            if (! (new Config)->includeCollection($handle)) {
                return;
            }

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
