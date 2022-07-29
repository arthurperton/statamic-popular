<?php

namespace Statamic\Addons\Popularity\Http\Middleware;

use Closure;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Statamic;
use Statamic\Structures\Page;
use Statamic\Support\Str;

class Popularity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    public function handle($request, Closure $next)
    {
        if (! env('POPULARITY_PAGEVIEWS_ENABLED', true)) {
            return $next($request);
        }

        if ($entry = Entry::findByUri($this->getUrl($request))) {
            if ($entry instanceof Page) {
                $entry = $entry->entry();
            }

            $entry->set('pageviews', $entry->get('pageviews', 0) + 1)->save();
            $entry->set('has_pageviews', true);
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
            $url = Str::after($url, '?');
        }

        if (Str::endsWith($url, '/') && Str::length($url) > 1) {
            $url = rtrim($url, '/');
        }

        return $url;
    }
}
