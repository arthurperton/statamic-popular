<?php

namespace ArthurPerton\Popular;

use ArthurPerton\Popular\Facades\Config;
use ArthurPerton\Popular\Facades\Pageviews;
use ArthurPerton\Popular\Pageviews\Database;
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
        Tags\PageviewCount::class,
        Tags\PopularScript::class,
    ];

    protected $widgets = [
        Widgets\MostPopular::class,
    ];

    protected $commands = [
        Console\Commands\Aggregate::class,
        Console\Commands\CreateDatabase::class,
        Console\Commands\Reset::class,
        Console\Commands\Stress::class,
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/app.js',
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

    public function bootAddon()
    {
        $this->createComputedValues();

        // Statamic::afterInstalled(function () {
        $this->app->make(Database::class)->create(); // database will only be created if it doesn't exist yet
        // });
    }

    protected function createComputedValues()
    {
        Collection::handles()->each(function ($handle) {
            if (! Config::collectionIncluded($handle)) {
                return;
            }

            Collection::computed($handle, 'pageviews', function ($entry) {
                if (! $id = $entry->id()) {
                    return 0;
                }

                return Pageviews::get($id);
            });
        });
    }

    protected function schedule($schedule)
    {
        $schedule->command('popular:aggregate')->everyMinute();
    }
}
