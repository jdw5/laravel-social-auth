<?php

use App\Events\Social\SocialAccountCreated;

return [

    'services' => [

        'github' => [
            'name' => 'GitHub',
        ],

    ],

    'events' => [
        'github' => [
            'created' => SocialAccountCreated::class
        ],
    ],

    //
];