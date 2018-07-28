<?php
/**
 * Coralogix logger handler for Monolog logging library
 *
 * @author Eldar Aliiev <eldar@coralogix.com>
 * @link https://coralogix.com/
 * @copyright Coralogix Ltd. 2018
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @version 1.0.0
 * @since 1.0.0
 * @link https://github.com/Seldaek/monolog Monolog logging library
 */

declare(strict_types=1);

namespace Coralogix\Handlers;


use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Coralogix\Severity;
use Coralogix\LoggerManager;


/**
 * Class CoralogixMonologHandler
 *
 * Coralogix logger handler for Monolog logging library
 * @package Coralogix
 * @property LoggerManager $logger_manager Coralogix logger manager
 * @final
 */
final class CoralogixMonologHandler extends AbstractProcessingHandler
{
    /**
     * @var LoggerManager Coralogix logger manager instance
     * @access private
     */
    private $logger_manager;

    /**
     * Logger handler constructor
     * @param string $private_key private key for Coralogix account
     * @param string $app_name your application name
     * @param string $subsystem subsystem of your application
     * @param int $level minimal logging level
     * @param bool $bubble use bubble
     */
    public function __construct(string $private_key = NULL, string $app_name = NULL, string $subsystem = NULL, $level = Logger::DEBUG, $bubble = true)
    {
        // Initialize logger manager thread
        $this->logger_manager = new LoggerManager(
            array(
                "privateKey" => $private_key,
                "applicationName" => $app_name,
                "subsystemName" => $subsystem
            ),
            true
        );

        // Start logger manager thread
        if ($this->logger_manager->configured) {
            $this->logger_manager->start();
        }

        // Run handler parent processes
        parent::__construct($level, $bubble);
    }

    /**
     * Close Coralogix logger manager before exit
     * @access public
     */
    public function __destruct()
    {
        $this->logger_manager->stop();
        parent::__destruct();
    }

    /**
     * Process log record
     * @param array $record log record
     * @access protected
     */
    protected function write(array $record)
    {
        $this->logger_manager->add_logline(
            $record["message"],
            self::severity_map($record['level']),
            NULL,
            $record["extra"]
        );
    }

    /**
     * Convert Monolog severity code to Coralogix severity
     * @param integer $severity_code Monolog severity code according to RFC5424
     * @access public
     * @static
     * @return integer Coralogix severity code
     */
    public static function severity_map(int $severity_code) {
        switch ($severity_code) {
            case 100: return Severity::DEBUG; // DEBUG
            case 200: return Severity::INFO; // INFO
            case 250: return Severity::WARNING; // NOTICE
            case 300: return Severity::WARNING; // WARNING
            case 400: return Severity::ERROR; // ERROR
            case 500: return Severity::CRITICAL; // CRITICAL
            case 550: return Severity::CRITICAL; // ALERT
            case 600: return Severity::CRITICAL; // EMERGENCY
            default: return Severity::DEBUG;
        }
    }
}