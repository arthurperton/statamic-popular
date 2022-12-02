<?php

namespace ArthurPerton\Statamic\Addons\Popular\Pageviews;

use Illuminate\Support\Collection;

class Repository
{
    protected $items;
    protected $file;

    public function __construct()
    {
        $this->file = new LockingFile(storage_path('popular/pageviews'));
    }

    public function get(string $entry): int
    {
        return (int) $this->items()->get($entry, 0);
    }

    public function all(): Collection
    {
        return $this->items();
    }

    public function update($updates): bool
    {
        return $this->file->modify(function ($data) use ($updates) {
            $this->items = collect($data ?: []);

            collect($updates)->each(function ($update) {
                $this->updateOne($update->entry, $update->views);
            });

            return $this->items->all();
        });
    }

    protected function updateOne($entry, $views)
    {
        $this->items()->put($entry, (int) $this->items()->get($entry, 0) + $views);
    }

    protected function items(): Collection
    {
        if (!$this->items) {
            $this->items = collect($this->file->read());
        }

        return $this->items;
    }
}
