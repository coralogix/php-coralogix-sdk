Monolog integration
===================

Coralogix PHP SDK provides logging handler for `Monolog <https://github.com/Seldaek/monolog>`_ logging library.

Example of usage:

.. code-block:: php

    <?php

    use Monolog\Logger;
    use Coralogix\Handler\CoralogixMonologHandler;


    $logger = new Logger("coralogix_logger");
    $logger->pushHandler(
        new CoralogixMonologHandler(
            "[YOUR_PRIVATE_KEY_HERE]",
            "[YOUR_APPLICATION_NAME]",
            "[YOUR_SUBSYTEM_NAME]"
        )
    );
    $logger->info("Hello from Monolog logging library");

For more details about usage of `Monolog`, please, read the `this manual <https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md>`_.