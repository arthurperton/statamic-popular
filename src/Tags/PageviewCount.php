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
            throw new \Exception("No id provided.");
        }

        if ($id instanceof Value) {
            $id = $id->value();
        }

        $count = Pageviews::get($id);

        return $this->isPair ? ['pageviews' => $count] : $count;
    }
}
