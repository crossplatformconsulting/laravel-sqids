<?php

declare(strict_types=1);

namespace Crossplatform\Sqids\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Prefix
{
    /**
     * @param  class-string<Model>  $model
     */
    public function prefix(string $model): string;
}
