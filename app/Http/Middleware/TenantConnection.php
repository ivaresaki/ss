<?php

namespace Org\Jvhsa\Surgiscript\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Orchestra\Support\Facades\Tenanti;
use Org\Jvhsa\Surgiscript\Site;

class TenantConnection
{
    protected $MAIN_DB_CONN = 'mysql';
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check to see if the request is for a subdomain
        $http_host_exploded = explode('.', $request->server('HTTP_HOST'));
        $subdomain = null;
        $site = null;
        // if has a signature of a subdomain
        // then set the $subdomain to the first part of the host
        if (count($http_host_exploded) != 3) {
            $subdomain = null;
        } else {
            $subdomain = $http_host_exploded[0];
        }
        // if the request is not for a subdomain
        // set the connection to the main db connection
        if ($subdomain == null) {
            session()->forget('subdomain');
            
            $this->switch_connection($this->MAIN_DB_CONN);
        } else {
            // switch to main connection to retrieve $site
            // produces error page if site does not exist
            // TODO: when subdomain does not exist, redirect to a friendlier
            // TODO: error page
            $site = Site::where('slug', '=', $subdomain)->firstOrFail();
            // if site is found for the requested subdomain
            // then switch db connection to that site
            if ($site != null) {
                Tenanti::driver('site')->asDefaultConnection($site, 'surgiscript_{$site->slug}');
                session()->put('subdomain', $site->slug);
            }
        }

        return $next($request);
    }

    /**
     * Switches db connection to the given connection name
     * @param $connection_name
     */
    protected function switch_connection($connection_name)
    {
        if ($connection_name == null) {
            return;
        }
        DB::purge();
        DB::setDefaultConnection($connection_name);
        DB::reconnect($connection_name);
    } // end of switch_connection
}
