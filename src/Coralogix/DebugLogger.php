<?php
/**
 * Internal debug logger class
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


/**
 * Class DebugLogger
 *
 * Coralogix logger for debug information
 * @package Coralogix
 * @property bool $debug_mode debug status (default=false)
 * @final
 */
final class DebugLogger
{
    /**
     * @var bool debug status (default=false)
     * @access public
     * @static
     */
    public static $debug_mode = false;

    /**
     * Send log message to STDOUT
     *
     * @param string $level log message level
     * @param string $message log message
     * @param \Exception $exception log exception information (default=null)
     * @access public
     * @static
     */
    public static function log(string $level, string $message, \Exception $exception = NULL)
    {
        // If debug mode is disabled - exit
        if (!self::$debug_mode) {
            return;
        }

        // Change message level to upper case
        $level = strtoupper($level);

        // If exception information passed
        if ($exception) {
            printf(
                "[%s][%s] - %s:\r\n%s\r\n",
                date("d-m-Y H:i:s"),
                $level,
                $message,
                (string)$exception
            );
        } else {
            printf(
                "[%s][%s] - %s\r\n",
                date("d-m-Y H:i:s"),
                $level,
                $message
            );
        }
    }

    /**
     * Log sending with default levels (DEBUG, INFO, WARNING, ERROR)
     *
     * @param string $level log message level
     * @param string $params log params
     * @access public
     * @static
     */
    public static function __callStatic(string $level, array $params)
    {
        list($message) = $params;
        // Check if log message level is in list of default levels or send with DEBUG level
        if (in_array(strtoupper($level), array("DEBUG", "INFO", "WARNING", "ERROR"))) {
            self::log($level, $message);
        } else {
            self::log("DEBUG", $message);
        }
    }

    /**
     * Sending log message with exception information
     *
     * @param string $message log message
     * @param \Exception $exception log exception information
     * @access public
     * @static
     */
    public static function exception(string $message, \Exception $exception)
    {
        self::log("ERROR", $message, $exception);
    }
}