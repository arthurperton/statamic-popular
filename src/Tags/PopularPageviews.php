<?php

namespace ArthurPerton\Statamic\Addons\Popular\Tags;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Repository;
use Statamic\Fields\Value;
use Statamic\Tags\Tags;

class PopularPageviews extends Tags
{
    public function index()
    {
        $id = $this->params['id'] ?? $this->context['id'] ?? null;

        if (!$id) {
            return 0;
        }

        if ($id instanceof Value) {
            $id = $id->value();
        }

        return (new Repository)->get($id);
    }
}
