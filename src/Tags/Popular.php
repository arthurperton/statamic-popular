<?php

namespace ArthurPerton\Statamic\Addons\Popular\Tags;

use Statamic\Support\Arr;
use Statamic\Tags\Collection\Collection;

class Popular extends Collection
{
    protected function entries()
    {
        $params = $this->params;

        $sort = 'has_pageviews|pageviews:desc';

        if ($sortExtra = Arr::getFirst($this->params, ['order_by', 'sort'])) {
            $sort = $sort . '|' . $sortExtra;
        }

        unset($params['order_by']);

        $params['sort'] = $sort;

        // return parent::entries($params);
        return new Entries($params);
    }
}
