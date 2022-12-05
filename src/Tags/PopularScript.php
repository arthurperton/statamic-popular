<?php

namespace ArthurPerton\Popular\Tags;

use Statamic\Tags\Tags;

class PopularScript extends Tags
{
    public function index()
    {
        return str_replace(["\r", "\n", '  '], '', sprintf("
            <script>
                (function(){
                    var formData = new FormData();
        
                    formData.append('_token', '%s');
                    formData.append('entry', '%s');
        
                    navigator.sendBeacon('/!/popular/pageviews', formData);
                })();
            </script>
        ", csrf_token(), $this->context['id']));
    }
}
