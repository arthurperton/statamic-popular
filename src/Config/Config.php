<?php

namespace ArthurPerton\Statamic\Addons\Popular\Config;

class Config
{
    public function includeCollection(string $handle): bool
    {
        $collections = config('statamic.popular.collections');

        return collect($collections)->contains(function ($pattern) use ($handle) {
            if ($handle === $pattern) return true;
            
            if (! str_contains($pattern, '*')) return false;

            // TODO is it worth to cache the patterns?
            return preg_match('/^'.str_replace('*', '.*', $pattern).'$/', $handle);
        });
    }
}
