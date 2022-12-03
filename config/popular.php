<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Tracker
    |--------------------------------------------------------------------------
    |
    | You might want to turn off pageview tracking in some environments.
    |
    */

    'tracker_enabled' => env('POPULAR_TRACKER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    | To include all collections use:
    |
    |     'include_collections' => ['*'],
    |
    |     'exclude_collections' => [],
    |
    */

    'include_collections' => ['*'],

    'exclude_collections' => [],

    /*
    |--------------------------------------------------------------------------
    | Add Pageviews Field
    |--------------------------------------------------------------------------
    |
    | This will add a read-only 'Pageviews' field to your entry blueprints 
    | on-the-fly.
    |
    */

    'add_field' => env('POPULAR_ADD_FIELD', true),

    /*
    |--------------------------------------------------------------------------
    | Database Path
    |--------------------------------------------------------------------------
    |
    | This is the directory where the sqlite database is stored.
    |
    */

    'database' => env('POPULAR_DATABASE', database_path('popular')),

    /*
    |--------------------------------------------------------------------------
    | Storage Path
    |--------------------------------------------------------------------------
    |
    | This is the directory where the pageview counts are stored.
    |
    */

    'files' => env('POPULAR_FILES', storage_path('popular')),
];
