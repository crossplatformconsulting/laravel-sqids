<?php

declare(strict_types=1);

namespace Crossplatform\Sqids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Crossplatform\Sqids\Mixins\FindBySqidMixin;
use Crossplatform\Sqids\Mixins\FindBySqidOrFailMixin;
use Crossplatform\Sqids\Mixins\WhereSqidInMixin;
use Crossplatform\Sqids\Mixins\WhereSqidMixin;
use Crossplatform\Sqids\Mixins\WhereSqidNotInMixin;

class SqidsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(path: __DIR__ . '/../config/sqids.php', key: 'sqids');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../config/sqids.php' => config_path('sqids.php'),
                ],
                groups: 'sqids-config',
            );
        }

        $this->bootBuilderMixins();
    }

    protected function bootBuilderMixins(): void
    {
        Builder::mixin(new FindBySqidMixin());
        Builder::mixin(new FindBySqidOrFailMixin());
        Builder::mixin(new WhereSqidInMixin());
        Builder::mixin(new WhereSqidMixin());
        Builder::mixin(new WhereSqidNotInMixin());
    }
}
