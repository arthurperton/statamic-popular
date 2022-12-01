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

    public function get($entry)
    {
        return $this->items()->get($entry, 0);
    }

    public function all()
    {
        return $this->items();
    }

    public function update($updates)
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
