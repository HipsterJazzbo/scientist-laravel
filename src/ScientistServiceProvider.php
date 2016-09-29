<?php

namespace Scientist\Laravel;

use Scientist\Laboratory;
use Illuminate\Support\ServiceProvider;

/**
 * Class ScientistServiceProvider
 *
 * @package \Scientist\Laravel
 */
class ScientistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // TODO: Register routes for interface

        // TODO: Build views for interface.
        //   - list experiments
        //   - show experiment (list results)
        //   - show result?

        // TODO: $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(['scientist', Laboratory::class], function () {
            $laboratory = new Laboratory();

            $laboratory->addJournal(new EloquentJournal());

            return $laboratory;
        });
    }
}
