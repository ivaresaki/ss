<?php

use Illuminate\Support\Facades\Log;

/**
 * Overrides Illuminate\Foundation\helpers::route()
 * @param  [type]  $name       [description]
 * @param  array   $parameters [description]
 * @param  boolean $absolute   [description]
 * @return [type]              [description]
 */
function route($name, $parameters = [], $absolute = true)
{
    // grap the subdomain from the session
    // it is set in the session with TenantConnection middleware
    $subdomain = session()->get('subdomain');

    if(!empty($subdomain))
    {
        $parameters['subdomain'] = $subdomain;
    }
    return app('url')->route($name, $parameters, $absolute);
}

function isSubdomain()
{
    return !empty(session()->get('subdomain'));
}

// function getCurrentSubdomain()
// {
// 	if(!isSubdomain())
// 	{
// 		return '';
// 	}

// 	return 
// }
