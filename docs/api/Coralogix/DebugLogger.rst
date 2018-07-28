.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DebugLogger
===========


.. php:namespace:: Coralogix

.. rst-class::  final

.. php:class:: DebugLogger


	.. rst-class:: phpdoc-description
	
		| Class DebugLogger
		
		| Coralogix logger for debug information
		
	

Properties
----------

.. php:attr:: public debug_mode

	:Type: bool debug status \(default=false\)


Methods
-------

.. rst-class:: public static

	.. php:method:: public static log(string $level, string $message, \\Exception $exception=NULL)
	
		.. rst-class:: phpdoc-description
		
			| Send log message to STDOUT
			
		
		
		:Parameters:
			* **$level** (string)  log message level
			* **$message** (string)  log message
			* **$exception** (:any:`Exception <Exception>`)  log exception information (default=null)

		
	
	

.. rst-class:: public static

	.. php:method:: public static __callStatic(string $level, array $params)
	
		.. rst-class:: phpdoc-description
		
			| Log sending with default levels \(DEBUG, INFO, WARNING, ERROR\)
			
		
		
		:Parameters:
			* **$level** (string)  log message level
			* **$params** (string)  log params

		
	
	

.. rst-class:: public static

	.. php:method:: public static exception(string $message, \\Exception $exception)
	
		.. rst-class:: phpdoc-description
		
			| Sending log message with exception information
			
		
		
		:Parameters:
			* **$message** (string)  log message
			* **$exception** (:any:`Exception <Exception>`)  log exception information

		
	
	

