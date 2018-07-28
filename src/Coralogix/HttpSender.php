<?php
/**
 * Coralogix logger HTTP sender
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
use Coralogix\DebugLogger;


/**
 * Class HttpSender
 *
 * HTTP sender for Coralogix logger
 * @package Coralogix
 * @property integer $timeout timeout of HTTP request (default=30s)
 * @abstract
 */
abstract class HttpSender extends \Thread
{
    /**
     * @var integer timeout of HTTP request (default=30s)
     * @access public
     * @static
     */
    public static $timeout = 30;

    /**
     * Set parameters of HTTP sender
     *
     * @param integer $timeout timeout of HTTP request
     * @access public
     * @static
     */
    public static function init(int $timeout)
    {
        // Set timeout of HTTP request to given or to default
        self::$timeout = ($timeout > 0) ? $timeout : Constants::HTTP_TIMEOUT;
    }

    /**
     * Send logs bulk via HTTP to Coralogix servers
     *
     * @param array $bulk logs bulk
     * @param string $url url to send
     * @param integer $retries retries count
     * @access public
     * @static
     * @return integer response code
     */
    public static function send_request(array $bulk, string $url = Constants::CORALOGIX_LOG_URL, int $retries = Constants::HTTP_SEND_RETRY_COUNT): int
    {
        // Execute HTTP request n-times until not get result
        for ($attempt = 1; $attempt <= $retries; $attempt++) {
            try {
                DebugLogger::info("About to send bulk to Coralogix server. Attempt number: $attempt");

                // Setup cURL instance
                $ch = curl_init($url);

                // Set request options
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bulk));

                // Send HTTP request
                curl_exec($ch);

                // Get response code
                $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

                // Close HTTP session
                curl_close($ch);

                // Check if request was successful
                if ($response_code != 200) {
                    throw new \Exception("HTTP requests was failed with code: " . $response_code);
                }

                DebugLogger::info("Successfully sent bulk to Coralogix server. Result is: $response_code");
                return $response_code;

            } catch (\Exception $e) {
                DebugLogger::exception("Failed to send HTTP POST request", $e);
            }

            DebugLogger::error("Failed to send bulk. Will retry in: " . Constants::HTTP_SEND_RETRY_INTERVAL . " seconds...");

            // Sleep before next attempt
            sleep(Constants::HTTP_SEND_RETRY_INTERVAL);
        }

        return 0;
    }

    /**
     * Get time difference between local machine and Coralogix servers
     *
     * @param string $url url to get servers time
     * @return array result of execution and time difference
     */
    public static function get_time_sync(string $url = Constants::CORALOGIX_TIME_DELTA_URL): array
    {
        try {
            DebugLogger::info("Syncing time with Coralogix server...");

            // Setup cURL instance
            $ch = curl_init($url);

            // Set request options
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // Send HTTP request and get result
            $response = curl_exec($ch);

            // Get response code
            $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

            // Close HTTP session
            curl_close($ch);

            // If response is not empty and status is success
            if ($response && $response_code == 200) {
                // Calculating time difference
                $server_time = (int)$response / 1E4;
                $local_time = time() * 1E3;
                $time_delta = $server_time - $local_time;

                DebugLogger::info("Server epoch time=$server_time, local epoch time=$local_time; Updating time delta to: $time_delta");

                // Return result and time difference
                return array(true, $time_delta);
            } else {
                // ... or throw new exception if response is failed
                throw new \Exception("Response failed with code " . $response_code);
            }
        } catch (\Exception $e) {
            DebugLogger::exception("Failed to send HTTP GET request", $e);

            // ... and fails result
            return array(false, 0);
        }
    }
}