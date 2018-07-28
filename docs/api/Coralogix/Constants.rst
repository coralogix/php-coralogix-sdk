.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Constants
=========


.. php:namespace:: Coralogix

.. rst-class::  abstract

.. php:class:: Constants


	.. rst-class:: phpdoc-description
	
		| Class Constants
		
		| Constants structure for Coralogix logger
		
	

Constants
---------

.. php:const:: MAX_LOG_BUFFER_SIZE = 12 \* 1024 \*\* 2

	:Type: int maximum log buffer size \(default=12MiB\)


.. php:const:: MAX_LOG_CHUNK_SIZE = 1\.5 \* 1024 \*\* 2

	:Type: int maximum chunk size \(default=1\.5MiB\)


.. php:const:: NORMAL_SEND_SPEED_INTERVAL = 500\.0 / 1000

	:Type: float bulk send interval in normal mode


.. php:const:: FAST_SEND_SPEED_INTERVAL = 100\.0 / 1000

	:Type: float bulk send interval in fast mode


.. php:const:: CORALOGIX_LOG_URL = https://api\.coralogix\.com:443/api/v1/logs

	:Type: string Coralogix logs url endpoint


.. php:const:: CORALOGIX_TIME_DELTA_URL = https://api\.coralogix\.com:443/sdk/v1/time

	:Type: string Coralogix time delay url endpoint


.. php:const:: TIME_DELAY_TIMEOUT = 1

	:Type: int timeout for time\-delay request


.. php:const:: FAILED_PRIVATE_KEY = no private key

	:Type: string default private key


.. php:const:: NO_APP_NAME = NO\_APP\_NAME

	:Type: string default application name


.. php:const:: NO_SUB_SYSTEM = NO\_SUB\_NAME

	:Type: string default subsystem name


.. php:const:: LOG_FILE_NAME = coralogix\.sdk\.log

	:Type: string log file name


.. php:const:: HTTP_TIMEOUT = 30

	:Type: int default http timeout


.. php:const:: HTTP_SEND_RETRY_COUNT = 5

	:Type: int number of attempts to retry HTTP post


.. php:const:: HTTP_SEND_RETRY_INTERVAL = 2

	:Type: int interval between failed http post requests


.. php:const:: CORALOGIX_CATEGORY = CORALOGIX

	:Type: string default category for log record


.. php:const:: SYNC_TIME_UPDATE_INTERVAL = 5

	:Type: int time synchronization interval \(in minutes\)


