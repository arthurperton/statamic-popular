<?php

namespace ArthurPerton\Statamic\Addons\Popular\Http\Middleware;

use Closure;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Statamic;
use Statamic\Structures\Page;
use Statamic\Support\Str;

class UpdatePageviews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! env('POPULAR_PAGEVIEWS_ENABLED', true)) {
            return $next($request);
        }

        if ($entry = Entry::findByUri($this->getUrl($request))) {
            if ($entry instanceof Page) {
                $entry = $entry->entry();
            }

            /** @var \Statamic\Entries\Entry $entry */
            $entry->set('pageviews', $entry->get('pageviews', 0) + 1);
            $entry->set('has_pageviews', true);
            $entry->save();
        }

        return $next($request);
    }

    private function getUrl($request)
    {
        $url = Site::current()->relativePath($request->getUri());

        if (Statamic::isAmpRequest()) {
            $url = Str::after($url, '/'.config('statamic.amp.route'));
        }

        if (Str::contains($url, '?')) {
            $url = Str::before($url, '?');
        }

        return $url;
    }
}
