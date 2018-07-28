.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HttpSender
==========


.. php:namespace:: Coralogix

.. rst-class::  abstract

.. php:class:: HttpSender


	.. rst-class:: phpdoc-description
	
		| Class HttpSender
		
		| HTTP sender for Coralogix logger
		
	
	:Parent:
		:php:class:`Thread`
	

Properties
----------

.. php:attr:: public timeout

	:Type: int timeout of HTTP request \(default=30s\)


Methods
-------

.. rst-class:: public static

	.. php:method:: public static init(int $timeout)
	
		.. rst-class:: phpdoc-description
		
			| Set parameters of HTTP sender
			
		
		
		:Parameters:
			* **$timeout** (int)  timeout of HTTP request

		
	
	

.. rst-class:: public static

	.. php:method:: public static send_request(array $bulk, string $url=\\Coralogix\\Constants::CORALOGIX\_LOG\_URL, int $retries=\\Coralogix\\Constants::HTTP\_SEND\_RETRY\_COUNT)
	
		.. rst-class:: phpdoc-description
		
			| Send logs bulk via HTTP to Coralogix servers
			
		
		
		:Parameters:
			* **$bulk** (array)  logs bulk
			* **$url** (string)  url to send
			* **$retries** (int)  retries count

		
		:Returns: int response code
	
	

.. rst-class:: public static

	.. php:method:: public static get_time_sync(string $url=\\Coralogix\\Constants::CORALOGIX\_TIME\_DELTA\_URL): array
	
		.. rst-class:: phpdoc-description
		
			| Get time difference between local machine and Coralogix servers
			
		
		
		:Parameters:
			* **$url** (string)  url to get servers time

		
		:Returns: array result of execution and time difference
	
	

