Yii2 integration
================

For using with `Yii2` you should install `yii2-monolog <https://github.com/merorafael/yii2-monolog>`_ plugin and our logger handler to components:

.. code-block:: php

    use Coralogix\Handlers\CoralogixMonologHandler;

    //....

    return [
        //....
        'components' => [
            'monolog' => [
                'class' => '\Mero\Monolog\MonologComponent',
                'channels' => [
                    'main' => [
                        'handler' => [
                            [
                                'type' => 'stream',
                                'path' => '@app/runtime/logs/main_' . date('Y-m-d') . '.log',
                                'level' => 'debug'
                            ],
                            new Coralogix\Handlers\CoralogixMonologHandler(
                                "[YOUR_PRIVATE_KEY_HERE]",
                                "[YOUR_APPLICATION_NAME]",
                                "[YOUR_SUBSYSTEM_NAME]"
                            )
                        ],
                        'processor' => [],
                    ]
                ],
            ],
        ],
        //....
    ];

To usage instruction, please, watch `this manual <https://github.com/merorafael/yii2-monolog#using-yii2-monolog>`_.