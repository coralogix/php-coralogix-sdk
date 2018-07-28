Implementation
==============

If you will use it simply, you should initialize `Composer` application and install `Coralogix` PHP SDK:

.. code-block:: bash

    $ composer init
    $ composer require "coralogix/php-coralogix-sdk"

Then you need to include to your script **autoload file**:

.. code-block:: php

    require 'vendor/autoload.php';

And then you can use `Coralogix` logger:

.. code-block:: php

    <?php

    require_once "vendor/autoload.php";

    use Coralogix\CoralogixLogger;

    // Initialize logger with your credentials
    $logger = new CoralogixLogger(
        "[YOUR_PRIVATE_KEY_HERE]",
        "[YOUR_APPLICATION_NAME]",
        "[YOUR_SUBSYTEM_NAME]"
    );

    // Send log message
    $logger->info("Hello from Coralogix PHP SDK");

