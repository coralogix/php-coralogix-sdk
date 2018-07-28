<?php
/**
 * Coralogix logger instance
 *
 * @author Eldar Aliiev <eldar@coralogix.com>
 * @link https://coralogix.com/
 * @copyright Coralogix Ltd. 2018
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Coralogix;


use Coralogix\Constants;
use Coralogix\Severity;
use Coralogix\DebugLogger;
use Coralogix\LoggerManager;


/**
 * Class CoralogixLogger
 *
 * Coralogix logger instance
 * @package Coralogix
 * @property LoggerManager $logger_manager logger manager instance
 * @property string $category default category for log records
 * @final
 */
final class CoralogixLogger
{
    /**
     * @var LoggerManager logger manager instance
     * @access private
     */
    private $logger_manager;

    /**
     * @var string default category for log records
     * @access private
     */
    private $category;

    /**
     * Initialize Coralogix logger instance and start logger manager
     * @param string $private_key private key for Coralogix account
     * @param string $app_name your application name
     * @param string $subsystem subsystem of your application
     * @param string $category category for log records
     * @param bool $sync_time synchronize local time with Coralogix servers
     * @access public
     */
    public function __construct(string $private_key = NULL, string $app_name = NULL, string $subsystem = NULL, string $category = NULL, bool $sync_time = false)
    {
        // Validate private key
        $private_key = ($private_key && !ctype_space($private_key)) ? $private_key : Constants::FAILED_PRIVATE_KEY;

        // Validate application name
        $app_name = ($app_name && !ctype_space($app_name)) ? $app_name : Constants::NO_APP_NAME;

        // Validate subsystem name
        $subsystem = ($subsystem && !ctype_space($subsystem)) ? $subsystem : Constants::NO_SUB_SYSTEM;

        // Initialize logger manager thread
        $this->logger_manager = new LoggerManager(
            array(
                "privateKey" => $private_key,
                "applicationName" => $app_name,
                "subsystemName" => $subsystem
            ),
            $sync_time
        );

        // Validate category
        $this->category = (!is_null($category)) ? $category : Constants::CORALOGIX_CATEGORY;

        // Start logger manager thread
        if ($this->logger_manager->configured) {
            $this->logger_manager->start();
        }
    }

    /**
     * Set debug output mode
     * @param bool $debug_mode new debug mode status
     * @access public
     * @static
     * @return bool changed debug mode status
     */
    public static function set_debug_mode(bool $debug_mode): bool
    {
        DebugLogger::$debug_mode = $debug_mode;
        return DebugLogger::$debug_mode;
    }

    /**
     * Add log record to sending queue
     * @param integer $severity log record level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function log(int $severity, $message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        // Validate category
        $category = $category ? $category : $this->category;

        // Validate thread ID
        $thread_id = ($thread_id && !ctype_space($thread_id)) ? $thread_id : \Thread::getCurrentThreadId();

        // Add log record to logs manager
        $this->logger_manager->add_logline(
            $message,
            $severity,
            $category,
            array(
                "className" => $class_name,
                "methodName" => $method_name,
                "threadId" => (string)$thread_id
            )
        );
    }

    /**
     * Send log message with DEBUG level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function debug($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::DEBUG, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Send log message with VERBOSE level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function verbose($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::VERBOSE, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Send log message with INFO level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function info($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::INFO, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Send log message with WARNING level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function warning($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::WARNING, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Send log message with ERROR level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function error($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::ERROR, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Send log message with CRITICAL level
     * @param string $message log record text
     * @param string $category log record category
     * @param string $class_name name of class from which log was sent
     * @param string $method_name name of method from which log was sent
     * @param string $thread_id ID of thread from which log was sent
     * @access public
     */
    public function critical($message, string $category = NULL, string $class_name = "", string $method_name = "", string $thread_id = "")
    {
        $this->log(Severity::CRITICAL, $message, $category, $class_name, $method_name, $thread_id);
    }

    /**
     * Stop logger manager before exit
     * @access public
     */
    public function __destruct()
    {
        $this->logger_manager->stop();
        unset($this->logger_manager);
    }

    /**
     * Get size of logs queue
     * @return integer size of logs queue
     */
    public function get_buffer_size(): int
    {
        return $this->logger_manager->get_buffer_size();
    }

    /**
     * Flush(send) logs queue manually
     * @access public
     */
    public function flush_messages()
    {
        $this->logger_manager->flush();
    }
}