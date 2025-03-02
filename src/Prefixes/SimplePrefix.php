<?php

declare(strict_types=1);

namespace Crossplatform\Sqids\Prefixes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Crossplatform\Sqids\Contracts\Prefix;

class SimplePrefix implements Prefix
{
    /**
     * Use the first 3 characters as the model prefix.
     *
     * @param  class-string<Model>  $model
     */
    public function prefix(string $model): string
    {
        $classBasename = class_basename(class: $model);

        $prefix = rtrim(mb_strimwidth(string: $classBasename, start: 0, width: 3, encoding: 'UTF-8'));

        return Str::lower(value: $prefix);
    }
}
