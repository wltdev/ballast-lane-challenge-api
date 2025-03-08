<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Test Case Class
    |--------------------------------------------------------------------------
    |
    | This option controls the default test case class that is used when
    | a test file does not define its own test case class. This should
    | typically remain set to the default value.
    |
    */

    'defaultTestCase' => 'Tests\TestCase',

    /*
    |--------------------------------------------------------------------------
    | Disable Colored Output
    |--------------------------------------------------------------------------
    |
    | This option allows you to disable colored output in the test results.
    | If you set this to true, Pest will not use colored output, even if
    | your terminal supports it. Set it to false to enable colored output.
    |
    */

    'colors' => true,

    /*
    |--------------------------------------------------------------------------
    | Test Runner
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the test runner to use. The default
    | runner is "pest", but you can change it to "phpunit" if you prefer
    | PHPUnit-style output for compatibility or other custom runners.
    |
    */

    'runner' => 'pest',

    /*
    |--------------------------------------------------------------------------
    | Watch Mode Options
    |--------------------------------------------------------------------------
    |
    | These options allow you to configure Pest's watch mode, which
    | automatically re-runs tests when files change. You can enable or
    | disable watch mode, specify the directories to watch, and more.
    |
    */

    'watch' => [
        'enabled' => env('PEST_WATCH', false),

        'paths' => [
            'app',
            'tests',
        ],

        'exclude' => [
            //
        ],
    ],

];
