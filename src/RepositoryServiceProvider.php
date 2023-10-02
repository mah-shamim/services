<?php

namespace VendorName\Skeleton;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $repositories = [
        //        interface => [
        //            'default' => eloquent repository,
        //            'mongodb' => mongodb repository,
        //        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $bindings) {
            $this->app->bind($interface, function ($app) use ($bindings) {
                return (config('database.default') == 'mongodb')
                    ? $app->make($bindings['mongodb'])
                    : $app->make($bindings['default']);
            });
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return array_keys($this->repositories);
    }
}
