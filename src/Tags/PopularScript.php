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

        $csrfToken = csrf_token();

        $storage = null;
        switch ($this->params['track'] ?? 'session') {
            case 'every':
            case 'always':
                $storage = 'undefined';
                break;
            case 'unique':
                $storage = 'localStorage';
                break;
            case 'session':
            default:
                $storage = 'sessionStorage';
                break;
        }


        $html = "
            <input id=\"popular-csrf-token\" type=\"hidden\" value=\"$csrfToken\" />
            <script>
                (function(){
                    const entry = '$id';

                    const storage = $storage;
                    
                    if (storage) {
                        const entries = JSON.parse(
                            storage.getItem('popular-entries') || '[]'
                        );

                        if (entries.includes(entry)) {
                            return;
                        }

                        storage.setItem(
                            'popular-entries', 
                            JSON.stringify([...entries, entry]),
                        );
                    }

                    const csrfToken = document.querySelector('#popular-csrf-token').value;

                    const body = new FormData();
        
                    body.append('_token', csrfToken);
                    body.append('entry', entry);

                    const url = '/!/popular/pageviews';

                    (navigator.sendBeacon && navigator.sendBeacon(url, body)) || fetch(url, { body, method: 'POST' });
                })();
            </script>
        ";

        return str_replace(["\r", "\n", '  '], '', $html);
    }
}
