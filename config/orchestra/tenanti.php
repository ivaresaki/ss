<?php

return [

    /*
    |----------------------------------------------------------------------
    | Driver Configuration
    |----------------------------------------------------------------------
    |
    | Setup your driver configuration to let us match the driver name to
    | a Model and path to migration.
    |
    */

    'drivers' => [
        'site' => [
            'model' => 'Org\Jvhsa\Surgiscript\Site',
            'path' => database_path('tenant/sites'),
            'shared' => false,
        ],
    ],
];
