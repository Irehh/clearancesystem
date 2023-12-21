<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => 'd0dddd17d1682f03481d', //Github API
        'client_secret' => '17fd93402d2525593de2503a0e5499bda56ac08a', //Github Secret
        'redirect' => 'http://localhost:8000/login/github/callback',
     ],
     'google' => [
        'client_id' => '58069217595-4634q9g7o52saatkqa4niojo8irq8sqg.apps.googleusercontent.com', //Google API
        'client_secret' => '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', //Google Secret
        'redirect' => 'http://localhost:8000/login/google/callback',
     ],
     'facebook' => [
        'client_id' => '807360757814879', //Facebook API
        'client_secret' => '9c815aae33d1e74a040347ca38a517ea', //Facebook Secret
        'redirect' => 'http://localhost:8000/login/facebook/callback',
     ],

];
