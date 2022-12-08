<?php

namespace ArthurPerton\Popular\Tags;

use ArthurPerton\Popular\Facades\Pageviews;
use Statamic\Fields\Value;
use Statamic\Tags\Tags;

class PageviewCount extends Tags
{
    public function index()
    {
        $id = $this->params['id'] ?? $this->context['id'] ?? null;

        if (! $id) {
            return 0;
        }

        if ($id instanceof Value) {
            $id = $id->value();
        }

        return Pageviews::get($id);
    }
}