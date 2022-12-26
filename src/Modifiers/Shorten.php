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

        return $this->shorten($value);
    }

    protected function shorten($number)
    {
        if ($number < 1E3) {
            return $number;
        }

        foreach (['K', 'M', 'B', 'T'] as $suffix) {
            $number /= 1E3;
            if ($number < 1E3) {
                break;
            }
        }

        return round($number, $number < 10 ? 1 : 0).$suffix;
    }
}
