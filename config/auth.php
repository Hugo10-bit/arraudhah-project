<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the number of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

    /*
    |--------------------------------------------------------------------------
    | Initial Seed Accounts Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi akun awal yang digunakan oleh AdminSeeder.
    | Nilai dibaca aman dari environment (.env) dan dapat di-cache (config:cache).
    |
    */

    'seed_admin' => [
        'name'     => env('ADMIN_NAME', 'Admin Ar-Raudhah'),
        'username' => env('ADMIN_USERNAME', 'admin'),
        'email'    => env('ADMIN_EMAIL', 'admin@arraudhah.id'),
        'password' => env('ADMIN_PASSWORD', null),
    ],

    'seed_penguji_tpq' => [
        'name'     => env('PENGUJI_TPQ_NAME', 'Ustadz Ahmad Al-Hafidz'),
        'username' => env('PENGUJI_TPQ_USERNAME', 'penguji_tpq'),
        'email'    => env('PENGUJI_TPQ_EMAIL', 'ahmad@arraudhah.id'),
        'password' => env('PENGUJI_TPQ_PASSWORD', null),
    ],

    'seed_penguji_rtq' => [
        'name'     => env('PENGUJI_RTQ_NAME', 'Ustadzah Fatimah Az-Zahra'),
        'username' => env('PENGUJI_RTQ_USERNAME', 'penguji_rtq'),
        'email'    => env('PENGUJI_RTQ_EMAIL', 'fatimah@arraudhah.id'),
        'password' => env('PENGUJI_RTQ_PASSWORD', null),
    ],

];
