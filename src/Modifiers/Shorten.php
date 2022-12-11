<?php

namespace ArthurPerton\Popular\Modifiers;

use Statamic\Modifiers\Modifier;

class Shorten extends Modifier
{
    public function index($value, $params, $context)
    {
        if (! $value) {
            return 0;
        }

        if ($value < 1E3) {
            return $value;
        }

        if ($value < 1E6) {
            return round($value / 1E3, 0).'K';
        }

        return round($value / 1E6, 1).'M';
    }
}
