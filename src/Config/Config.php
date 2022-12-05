<?php

namespace ArthurPerton\Popular\Config;

class Config
{
    public function includeCollection(string $handle): bool
    {
        $excludes = config('popular.exclude_collections') ?? [];
        $includes = config('popular.include_collections') ?? ['*'];

        if ($this->match($excludes, $handle)) {
            return false;
        }

        return $this->match($includes, $handle);
    }

    private function match(array $patterns, string $handle): bool
    {
        if (in_array('*', $patterns)) {
            return true;
        }

        return collect($patterns)->contains(function ($pattern) use ($handle) {
            if ($handle === $pattern) {
                return true;
            }

            if (! str_contains($pattern, '*')) {
                return false;
            }

            // TODO is it worth to cache the patterns?
            return preg_match('/^'.str_replace('*', '.*', $pattern).'$/', $handle);
        });
    }
}
