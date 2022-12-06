<?php

namespace ArthurPerton\Popular\Tags;

use Statamic\Tags\Tags;

class PopularScript extends Tags
{
    public function index()
    {
        $id = $this->params['id'] ?? $this->context['id'] ?? null;

        if (! $id) {
            return '<!-- Popular script omitted (id was not provided or available) -->';
        }

        return str_replace(["\r", "\n", '  '], '', sprintf("
            <script>
                (function(){
                    const url = '/!/popular/pageviews';
                    const body = JSON.stringify({ entry: '%s' });
                    (navigator.sendBeacon && navigator.sendBeacon(url, body)) || fetch(url, { body, method: 'POST' });
                })();
            </script>
        ", $id));
    }
}
