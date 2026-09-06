<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trading name (brand)
    |--------------------------------------------------------------------------
    |
    | Public-facing brand used across the site. Legal contracting entity remains
    | the registered company below.
    |
    */

    'trading_name' => env('COMPANY_TRADING_NAME', 'Brillia'),

    /*
    |--------------------------------------------------------------------------
    | Current product line
    |--------------------------------------------------------------------------
    |
    | Vertical-facing name while Brillia is energy-only. Swap or drop this when
    | expanding into other services.
    |
    */

    'product_name' => env('COMPANY_PRODUCT_NAME', 'Brillia Energy'),

    /*
    |--------------------------------------------------------------------------
    | Registered company
    |--------------------------------------------------------------------------
    */

    'legal_name' => env('COMPANY_LEGAL_NAME', 'Zynx Ltd'),

    'number' => env('COMPANY_NUMBER', '15822793'),

    'registered_office' => env(
        'COMPANY_REGISTERED_OFFICE',
        '11 Brendon Close, Grantham, Lincolnshire, United Kingdom, NG31 8FU'
    ),

    'country' => env('COMPANY_COUNTRY', 'United Kingdom'),

    /*
    |--------------------------------------------------------------------------
    | Public contact (optional)
    |--------------------------------------------------------------------------
    */

    'support_email' => env('COMPANY_SUPPORT_EMAIL', 'hello@brillia.test'),

];
