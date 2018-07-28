.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LoggerManager
=============


.. php:namespace:: Coralogix

.. rst-class::  final

.. php:class:: LoggerManager


	.. rst-class:: phpdoc-description
	
		| Class LoggerManager
		
	
	:Parent:
		:php:class:`Coralogix\\HttpSender`
	

Properties
----------

.. php:attr:: public static configured

	:Type: bool is logger manager configured


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(array $params, bool $sync_time=true)
	
		.. rst-class:: phpdoc-description
		
			| Initialize logger manager instance
			
		
		
		:Parameters:
			* **$params** (array)  configuration parameters(privateKey, applicationName, subsystemName)
			* **$sync_time** (bool)  synchronize local time with Coralogix servers

		
	
	

.. rst-class:: public

	.. php:method:: public __destruct()
	
		.. rst-class:: phpdoc-description
		
			| Stop logger manager on exit
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public run()
	
		.. rst-class:: phpdoc-description
		
			| Target function for thread in which executing logs sending process
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public stop()
	
		.. rst-class:: phpdoc-description
		
			| Stop logger manager
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public flush()
	
		.. rst-class:: phpdoc-description
		
			| Send all logs to Coralogix before exit
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public get_buffer_size(bool $in_bytes=false): int
	
		.. rst-class:: phpdoc-description
		
			| Get size of logs buffer
			
		
		
		:Parameters:
			* **$in_bytes** (bool)  return in bytes or in count of entries

		
		:Returns: int buffer size
	
	

.. rst-class:: public

	.. php:method:: public add_logline($message, int $severity, string $category=NULL, array $params=array\(\))
	
		.. rst-class:: phpdoc-description
		
			| Add logs line to logs buffer
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$severity** (int)  log record level
			* **$category** (string)  log record category
			* **$params** (array)  additional log record fields(className, methodName, threadId)

		
	
	

.. rst-class:: public

	.. php:method:: public msg2str($message): string
	
		.. rst-class:: phpdoc-description
		
			| Format message string to correct format
			
		
		
		:Parameters:
			* **$message** (string)  log record text

		
		:Returns: string formatted string
	
	

