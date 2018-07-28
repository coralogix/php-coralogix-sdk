<?php
/**
 * Coralogix logger constants class
 *
 * @author Eldar Aliiev <eldar@coralogix.com>
 * @link https://coralogix.com/
 * @copyright Coralogix Ltd. 2018
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @version 1.0.0
 * @since 1.0.0
 */

namespace Coralogix;


/**
 * Class Constants
 *
 * Constants structure for Coralogix logger
 * @package Coralogix
 * @property integer MAX_LOG_BUFFER_SIZE maximum log buffer size (default=12MiB)
 * @property integer MAX_LOG_CHUNK_SIZE maximum chunk size (default=1.5MiB)
 * @property float NORMAL_SEND_SPEED_INTERVAL bulk send interval in normal mode
 * @property float FAST_SEND_SPEED_INTERVAL bulk send interval in fast mode
 * @property string CORALOGIX_LOG_URL Coralogix logs url endpoint
 * @property string CORALOGIX_TIME_DELTA_URL Coralogix time delay url endpoint
 * @property integer TIME_DELAY_TIMEOUT timeout for time-delay request
 * @property string FAILED_PRIVATE_KEY default private key
 * @property string NO_APP_NAME default application name
 * @property string NO_SUB_SYSTEM default subsystem name
 * @property string LOG_FILE_NAME default log file name
 * @property integer HTTP_TIMEOUT default http timeout
 * @property integer HTTP_SEND_RETRY_COUNT number of attempts to retry HTTP post
 * @property integer HTTP_SEND_RETRY_INTERVAL interval between failed http post requests
 * @property string CORALOGIX_CATEGORY default category for log record
 * @property integer SYNC_TIME_UPDATE_INTERVAL time synchronization interval (in minutes)
 * @abstract
 */
abstract class Constants
{
    /**
     * @var integer maximum log buffer size (default=12MiB)
     */
    const MAX_LOG_BUFFER_SIZE = 12 * 1024 ** 2;

    /**
     * @var integer maximum chunk size (default=1.5MiB)
     */
    const MAX_LOG_CHUNK_SIZE = 1.5 * 1024 ** 2;

    /**
     * @var float bulk send interval in normal mode
     */
    const NORMAL_SEND_SPEED_INTERVAL = 500.0 / 1000;

    /**
     * @var float bulk send interval in fast mode
     */
    const FAST_SEND_SPEED_INTERVAL = 100.0 / 1000;

    /**
     * @var string Coralogix logs url endpoint
     */
    const CORALOGIX_LOG_URL = "https://api.coralogix.com:443/api/v1/logs";

    /**
     * @var string Coralogix time delay url endpoint
     */
    const CORALOGIX_TIME_DELTA_URL = "https://api.coralogix.com:443/sdk/v1/time";

    /**
     * @var integer timeout for time-delay request
     */
    const TIME_DELAY_TIMEOUT = 1;

    /**
     * @var string default private key
     */
    const FAILED_PRIVATE_KEY = "no private key";

    /**
     * @var string default application name
     */
    const NO_APP_NAME = "NO_APP_NAME";

    /**
     * @var string default subsystem name
     */
    const NO_SUB_SYSTEM = "NO_SUB_NAME";

    /**
     * @var string log file name
     */
    const LOG_FILE_NAME = "coralogix.sdk.log";

    /**
     * @var integer default http timeout
     */
    const HTTP_TIMEOUT = 30;

    /**
     * @var integer number of attempts to retry HTTP post
     */
    const HTTP_SEND_RETRY_COUNT = 5;

    /**
     * @var integer interval between failed http post requests
     */
    const HTTP_SEND_RETRY_INTERVAL = 2;
    /**
     * @var string default category for log record
     */
    const CORALOGIX_CATEGORY = "CORALOGIX";

    /**
     * @var integer time synchronization interval (in minutes)
     */
    const SYNC_TIME_UPDATE_INTERVAL = 5;
}