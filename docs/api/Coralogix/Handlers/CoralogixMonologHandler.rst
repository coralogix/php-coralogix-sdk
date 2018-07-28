.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CoralogixMonologHandler
=======================


.. php:namespace:: Coralogix\Handlers

.. rst-class::  final

.. php:class:: CoralogixMonologHandler


	.. rst-class:: phpdoc-description
	
		| Class CoralogixMonologHandler
		
		| Coralogix logger handler for Monolog logging library
		
	
	:Parent:
		:php:class:`Monolog\\Handler\\AbstractProcessingHandler`
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $private_key=NULL, $app_name=NULL, $subsystem=NULL, $level=\\Monolog\\Logger::DEBUG, $bubble=true)
	
		.. rst-class:: phpdoc-description
		
			| Logger handler constructor
			
		
		
		:Parameters:
			* **$private_key** (string)  private key for Coralogix account
			* **$app_name** (string)  your application name
			* **$subsystem** (string)  subsystem of your application
			* **$level** (int)  minimal logging level
			* **$bubble** (bool)  use bubble

		
	
	

.. rst-class:: public

	.. php:method:: public __destruct()
	
		.. rst-class:: phpdoc-description
		
			| Close Coralogix logger manager before exit
			
		
		
	
	

.. rst-class:: protected

	.. php:method:: protected write( $record)
	
		.. rst-class:: phpdoc-description
		
			| Process log record
			
		
		
		:Parameters:
			* **$record** (array)  log record

		
	
	

.. rst-class:: public static

	.. php:method:: public static severity_map( $severity_code)
	
		.. rst-class:: phpdoc-description
		
			| Convert Monolog severity code to Coralogix severity
			
		
		
		:Parameters:
			* **$severity_code** (int)  Monolog severity code according to RFC5424

		
		:Returns: int Coralogix severity code
	
	

