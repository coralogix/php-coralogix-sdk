.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CoralogixLogger
===============


.. php:namespace:: Coralogix

.. rst-class::  final

.. php:class:: CoralogixLogger


	.. rst-class:: phpdoc-description
	
		| Class CoralogixLogger
		
		| Coralogix logger instance
		
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(string $private_key=NULL, string $app_name=NULL, string $subsystem=NULL, string $category=NULL, bool $sync_time=false)
	
		.. rst-class:: phpdoc-description
		
			| Initialize Coralogix logger instance and start logger manager
			
		
		
		:Parameters:
			* **$private_key** (string)  private key for Coralogix account
			* **$app_name** (string)  your application name
			* **$subsystem** (string)  subsystem of your application
			* **$category** (string)  category for log records
			* **$sync_time** (bool)  synchronize local time with Coralogix servers

		
	
	

.. rst-class:: public static

	.. php:method:: public static set_debug_mode(bool $debug_mode): bool
	
		.. rst-class:: phpdoc-description
		
			| Set debug output mode
			
		
		
		:Parameters:
			* **$debug_mode** (bool)  new debug mode status

		
		:Returns: bool changed debug mode status
	
	

.. rst-class:: public

	.. php:method:: public log(int $severity, $message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Add log record to sending queue
			
		
		
		:Parameters:
			* **$severity** (int)  log record level
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public debug($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with DEBUG level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public verbose($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with VERBOSE level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public info($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with INFO level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public warning($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with WARNING level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public error($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with ERROR level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public critical($message, string $category=NULL, string $class_name="", string $method_name="", string $thread_id="")
	
		.. rst-class:: phpdoc-description
		
			| Send log message with CRITICAL level
			
		
		
		:Parameters:
			* **$message** (string)  log record text
			* **$category** (string)  log record category
			* **$class_name** (string)  name of class from which log was sent
			* **$method_name** (string)  name of method from which log was sent
			* **$thread_id** (string)  ID of thread from which log was sent

		
	
	

.. rst-class:: public

	.. php:method:: public __destruct()
	
		.. rst-class:: phpdoc-description
		
			| Stop logger manager before exit
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public get_buffer_size(): int
	
		.. rst-class:: phpdoc-description
		
			| Get size of logs queue
			
		
		
		:Returns: int size of logs queue
	
	

.. rst-class:: public

	.. php:method:: public flush_messages()
	
		.. rst-class:: phpdoc-description
		
			| Flush\(send\) logs queue manually
			
		
		
	
	

