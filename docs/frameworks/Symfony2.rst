Symfony2 integration
====================

For using our logger with `Symfony` you should to edit your default **monolog.yaml** file and add our handler:

.. code-block:: yaml

    monolog:
        handlers:
            main:
                type:  stream
                path:  %kernel.logs_dir%/%kernel.environment%.log
                level: debug
            coralogix:
                type: service
                id: coralogix_handler

    services:
        coralogix_handler:
            class: Coralogix\Handlers\CoralogixMonologHandler
            arguments:
                private_key: [YOUR_PRIVATE_KEY_HERE]
                app_name: [YOUR_APPLICATION_NAME]
                subsystem: [YOUR_SUBSYSTEM_NAME]