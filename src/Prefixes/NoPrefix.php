<?php

declare(strict_types=1);

namespace Crossplatform\Sqids\Prefixes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Crossplatform\Sqids\Contracts\Prefix;

class NoPrefix implements Prefix
{
    /**
     * Use the first 3 characters as the model prefix.
     *
     * @param  class-string<Model>  $model
     */
    public function prefix(string $model): string
    {
        return '';
    }
}
