Laravel integration
===================

For using our logger with `Laravel` you should to edit your **config/logging.php** file and add our handler:

.. code-block:: php

    use Coralogix\Handlers\CoralogixMonologHandler;

    return [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single', 'coralogix'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        //....

        'coralogix' => [
            'driver'  => 'monolog',
            'handler' => Coralogix\Handlers\CoralogixMonologHandler::class,
            'handler_with' => [
                'private_key' => '[YOUR_PRIVATE_KEY_HERE]',
                'app_name' => '[YOUR_APPLICATION_NAME]',
                'subsystem' => '[YOUR_SUBSYSTEM_NAME]'
            ],
        ],
    ];

And then you can send log messages with:

.. code-block:: php

    Log::info("Your message");