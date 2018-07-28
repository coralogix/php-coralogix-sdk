<?php
/**
 * Coralogix logger logs manager
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
use Coralogix\Helpers;


/**
 * Class LoggerManager
 * @package Coralogix\Logger
 * @property bool $configured is logger manager configured
 * @property bool $sync_time synchronize local time with Coralogix servers
 * @property integer $time_delta_last_update time of last synchronization with Coralogix servers
 * @property integer $time_delta difference between local time and Coralogix servers
 * @property integer $buffer_size size of logs buffer in bytes
 * @property array $buffer logs buffer
 * @property bool $stopped is current logger manager stopped manually
 * @property array $bulk_template template of logs bulk
 * @final
 */
final class LoggerManager extends HttpSender
{
    /**
     * @var bool is logger manager configured
     * @access public
     */
    public $configured;

    /**
     * @var bool synchronize local time with Coralogix servers
     * @access private
     */
    private $sync_time;

    /**
     * @var integer time of last synchronization with Coralogix servers
     * @access private
     */
    private $time_delta_last_update;

    /**
     * @var integer difference between local time and Coralogix servers
     * @access private
     */
    private $time_delta;

    /**
     * @var integer size of logs buffer in bytes
     * @access private
     */
    private $buffer_size;

    /**
     * @var array logs buffer
     * @access private
     */
    private $buffer;

    /**
     * @var bool is current logger manager stopped manually
     * @access private
     */
    private $stopped;

    /**
     * @var array template of logs bulk
     * @access private
     */
    private $bulk_template;

    /**
     * Initialize logger manager instance
     * @param bool $sync_time synchronize local time with Coralogix servers
     * @param array $params configuration parameters(privateKey, applicationName, subsystemName)
     * @access public
     */
    public function __construct(array $params, bool $sync_time = true)
    {
        try {
            // Initialize parameters
            $this->configured = false;
            $this->sync_time = (bool)$sync_time;
            $this->time_delta_last_update = 0;
            $this->time_delta = 0;
            $this->buffer_size = 0;
            $this->buffer = array();
            $this->stopped = false;

            // Fill template of logs bulk with default values
            $this->bulk_template = array(
                "privateKey" => Constants::FAILED_PRIVATE_KEY,
                "applicationName" => Constants::NO_APP_NAME,
                "subsystemName" => Constants::NO_SUB_SYSTEM
            );

            // Update template of logs bulk with user parameters
            $this->bulk_template->merge(
                array(
                    "computerName" => Helpers::get_computer_name(),
                    "IPAddress" => Helpers::get_computer_address()
                )
            );

            // Check logger parameters
            if(!array_key_exists("privateKey", $params) || !is_string($params["privateKey"])) {
                throw new \Exception("Invalid private key");
            }
            $this->bulk_template->merge($params);

            DebugLogger::info("Successfully configured Coralogix logger");

            // Change logger manager configured status to success
            $this->configured = true;

            // Send initialize message to Coralogix
            $this->send_init_message();
        } catch (\Exception $e) {
            if (!$this->stopped) {
                DebugLogger::exception("Failed to configure Coralogix logger", $e);

                // Change logger manager configured status to fails
                $this->configured = false;
            }
        }
    }

    /**
     * Stop logger manager on exit
     * @access public
     */
    public function __destruct()
    {
        $this->stop();
    }

    /**
     * Target function for thread in which executing logs sending process
     * @access public
     */
    public function run()
    {
        try {
            // Execute while thread not stopped
            while (true) {
                if ($this->stopped) {
                    // Flush buffer before exit
                    $this->flush();
                    return;
                }

                // Send logs bulk
                $this->send_bulk($this->sync_time);

                // Change logs sending interval
                if ($this->buffer_size > (Constants::MAX_LOG_CHUNK_SIZE / 2)) {
                    $next_check_interval = Constants::FAST_SEND_SPEED_INTERVAL;
                } else {
                    $next_check_interval = Constants::NORMAL_SEND_SPEED_INTERVAL;
                }

                DebugLogger::debug("Next buffer check is scheduled in $next_check_interval seconds");

                // Sleep before next sending
                sleep((int)$next_check_interval);
            }
        } catch (\Exception $e) {
            if (!$this->stopped) {
                DebugLogger::exception("Exception from the main buffer loop", $e);
            }
        }
    }

    /**
     * Stop logger manager
     * @access public
     */
    public function stop()
    {
        $this->stopped = true;
    }

    /**
     * Send all logs to Coralogix before exit
     * @access public
     */
    public function flush()
    {
        $this->send_bulk(false);
    }

    /**
     * Get size of logs buffer
     * @param bool $in_bytes return in bytes or in count of entries
     * @return int buffer size
     */
    public function get_buffer_size(bool $in_bytes = false): int
    {
        return $in_bytes ? $this->buffer_size : sizeof($this->buffer);
    }

    /**
     * Add logs line to logs buffer
     * @param string $message log record text
     * @param integer $severity log record level
     * @param string $category log record category
     * @param array $params additional log record fields(className, methodName, threadId)
     * @access public
     */
    public function add_logline($message, int $severity, string $category = NULL, array $params = array())
    {
        try {
            if ($this->buffer_size < Constants::MAX_LOG_BUFFER_SIZE) {
                // Validate message
                $message = ($message && !ctype_space((string)$message)) ? $this->msg2str($message) : "EMPTY_STRING";

                if ($severity < Severity::DEBUG || $severity > Severity::CRITICAL) {
                    $severity = Severity::DEBUG;
                }

                // Validate category
                $category = ($category && !ctype_space((string)$category)) ? $category : Constants::CORALOGIX_CATEGORY;

                // Combine a log-entry from the must parameters together with the optional one
                $new_entry = array_merge(
                    array(
                        "text" => $message,
                        "timestamp" => time() * 1000 + $this->time_delta,
                        "severity" => $severity,
                        "category" => $category,
                    ),
                    $params
                );

                // Get new entry size
                $new_entry_size = strlen(json_encode($new_entry, JSON_UNESCAPED_UNICODE));

                // If log record bigger than maximal size throw error
                if (Constants::MAX_LOG_CHUNK_SIZE <= $new_entry_size) {
                    DebugLogger::warning(
                        sprintf(
                            "add_logline(): received log message too big of size= %d MB, bigger than max_log_chunk_size= %d; throwing...",
                            (int)($new_entry_size / 1024 ** 2),
                            Constants::MAX_LOG_CHUNK_SIZE
                        )
                    );
                    throw new \Exception("Log message is two large");
                }

                // Add log entry to logs buffer
                $this->buffer[] = $new_entry;

                // Update the buffer size to reflect the new size
                $this->buffer_size += $new_entry_size;

            }
        } catch (\Exception $e) {
            if (!$this->stopped) {
                DebugLogger::exception("Failed to add log to buffer", $e);
            }
        }
    }

    /**
     * Send initialize message to Coralogix at start of working
     * @access private
     */
    private function send_init_message()
    {
        // Send to Coralogix record with information about current logger
        $this->add_logline(
            sprintf(
                "The Application Name %s and Subsystem Name %s from the PHP SDK, version %s has started to send data",
                $this->bulk_template['applicationName'],
                $this->bulk_template['subsystemName'],
                Helpers::get_package_version()
            ),
            Severity::INFO,
            Constants::CORALOGIX_CATEGORY,
            array(
                "threadId" => (string)(\Thread::getCurrentThreadId())
            )
        );
    }

    /**
     * Send logs bulk to Coralogix
     * @param bool $time_sync synchronize local time with Coralogix servers
     * @access private
     */
    private function send_bulk(bool $time_sync = true)
    {
        try {
            // Check if current logger manager is configured
            if (!$this->configured) return;

            // Check if time synchronization required
            if ($time_sync) {
                $this->update_time_delta_interval();
            }

            // Total buffer size
            $size = $this->buffer->count();
            if ($size < 1) {
                DebugLogger::info("Buffer is empty, there is nothing to send!");
                return;
            }

            // If the size is bigger than the maximum allowed chunk size then split it by half.
            // Keep splitting it until the size is less than MAX_LOG_CHUNK_SIZE
            $buffer_copy = (array)$this->buffer;
            while ((strlen(json_encode(array_slice($buffer_copy, 0, $size), JSON_UNESCAPED_UNICODE)) > Constants::MAX_LOG_CHUNK_SIZE) && $size > 1) {
                $size = (int)($size / 2);
            }

            // We must take at least one value.
            // If the first message is bigger than MAX_LOG_CHUNK_SIZE
            // we need to take it anyway.
            $size = $size > 0 ? $size : 1;

            DebugLogger::info("Checking buffer size. Total log entries is: $size");

            // Get logs entries
            $bulk = (array)$this->bulk_template;
            for ($i = 0; $i < $size; $i++) {
                $bulk["logEntries"][] = (array)$this->buffer->pop();
            }

            // Extract from the buffer size the total amount of the logs we removed from the buffer
            $this->buffer_size -= (strlen(json_encode($bulk["logEntries"], JSON_UNESCAPED_UNICODE)) - $size * 2);

            // Make sure we are always positive
            $this->buffer_size = max($this->buffer_size, 0);

            DebugLogger::info("Buffer size after removal is: " . $this->buffer_size);

            // Sending bulk
            if ($bulk["logEntries"]) {
                self::send_request($bulk);
            }
        } catch (\Exception $e) {
            DebugLogger::exception("Failed to send bulk", $e);
        }
    }

    /**
     * Format message string to correct format
     * @param string $message log record text
     * @access public
     * @return string formatted string
     */
    public function msg2str($message): string
    {
        try {
            // Format message content according to it's type
            if (is_string($message)) {
                return $message;
            } else if (is_array($message) || is_object($message)) {
                return json_encode($message, JSON_UNESCAPED_UNICODE);
            } else if (is_null($message)) {
                return "";
            } else {
                throw new \Exception("Invalid format");
            }
        } catch (\Exception $e) {
            return (string)$message;
        }
    }

    /**
     * Get time difference between local machine and Coralogix servers
     * @access private
     */
    private function update_time_delta_interval()
    {
        try {
            if (time() - $this->time_delta_last_update >= 60 * Constants::SYNC_TIME_UPDATE_INTERVAL) {
                // Get time information from Coralogix servers
                list($result, $time_delta) = self::get_time_sync();

                // If information was got successfully - update time difference information
                if ($result) {
                    $this->time_delta = $time_delta;
                    $this->time_delta_last_update = time();
                } else {
                    // ... or throw exception
                    throw new \Exception("Time synchronization was unsuccessful");
                }
            }
        } catch (\Exception $e) {
            if (!$this->stopped) {
                DebugLogger::exception("Failed to update time sync", $e);
            }
        }
    }
}