<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'mailerlite' => [
        'key' => env('MAILERLITE_API_KEY'),
        'group_id' => env('MAILERLITE_GROUP_ID'),
    ],

    'energy_shop' => [
        'switching_base_url' => env('ENERGY_SHOP_SWITCHING_BASE_URL'),
        'tariff_feed_base_url' => env('ENERGY_SHOP_TARIFF_FEED_BASE_URL'),
        'api_key' => env('ENERGY_SHOP_API_KEY'),
        'timeout' => env('ENERGY_SHOP_TIMEOUT', 20),
    ],

];
