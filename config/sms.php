<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application username
    |--------------------------------------------------------------------------
    |
    | This value is the username of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'api_key' => env('SMS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Application password
    |--------------------------------------------------------------------------
    |
    | This value determines the "password" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'sender_id' => env('SMS_SENDER_ID', ''),
    /*
    |--------------------------------------------------------------------------
    | Application password
    |--------------------------------------------------------------------------
    |
    | This value determines the "password" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'base_uri' => env('SMS_API_BASE_URI', 'https://esms.mimsms.com/'),

    /*
    |--------------------------------------------------------------------------
    | Application password
    |--------------------------------------------------------------------------
    |
    | This value determines the "password" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'verify' => env('SMS_API_VERIFY', false),




];
