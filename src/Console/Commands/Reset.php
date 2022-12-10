<?php

namespace ArthurPerton\Popular\Console\Commands;

use ArthurPerton\Popular\Facades\Pageviews;
use Illuminate\Console\Command;
use Statamic\Facades\Collection;

class Reset extends Command
{
    protected $signature = 'popular:reset
        { collection? : The handle of the collection for which the pageviews should be reset. }
        { --all : Reset pageviews for all collections. }';

    protected $description = 'Reset pageview counts to zero.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $collections = $this->getCollections();

        $ids = $collections
            ->map(function ($handle) {
                return Collection::findByHandle($handle);
            })->flatMap(function ($collection) {
                return $collection->queryEntries()->get()->map->id();
            })->all();

        if (! Pageviews::resetMultiple($ids)) {
            return 1;
        }

        foreach ($collections as $handle) {
            $this->info("Collection <comment>{$handle}</comment> reset.");
        }

        return 0;
    }

    private function getCollections(): \Illuminate\Support\Collection
    {
        if ($collection = $this->argument('collection')) {
            if (! $this->collectionExists($collection)) {
                throw new \InvalidArgumentException("Collection [$collection] does not exist.");
            }

            return collect($collection);
        }

        if ($this->option('all')) {
            return $this->collections();
        }

        $selection = $this->choice(
            'Select a collection to update',
            collect(['all'])->merge($this->collections())->all(),
            0
        );

        return ($selection == 'all') ? $this->collections() : collect($selection);
    }

    private function collections(): \Illuminate\Support\Collection
    {
        return Collection::handles(); // TODO only configured?
    }

    private function collectionExists($collection): bool
    {
        return $this->collections()->contains($collection);
    }
}
