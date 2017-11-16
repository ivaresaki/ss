<?php

namespace Org\Jvhsa\Surgiscript\Providers;

use Illuminate\Support\ServiceProvider;
use Orchestra\Support\Facades\Tenanti;
use Org\Jvhsa\Surgiscript\Observers\SiteObserver;
use Org\Jvhsa\Surgiscript\Observers\UserObserver;
use Org\Jvhsa\Surgiscript\Site;
use Org\Jvhsa\Surgiscript\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Site::observe(new SiteObserver());
        // User::observe(new UserObserver());

        Tenanti::connection('tenants', function (Site $entity, array $config) {
            $config['database'] = "surgiscript_{$entity->slug}"; 
            // refer to config under `database.connections.tenants.*`.

            return $config;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
