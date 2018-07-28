<?php

namespace Coralogix;


use Coralogix\Severity;
use Coralogix\CoralogixLogger;


class CoralogixLoggerTest extends \PHPUnit\Framework\TestCase
{
    private static $logger;

    public static function setUpBeforeClass()
    {
        self::$logger = new CoralogixLogger(
            getenv("PRIVATE_KEY"),
            "Coralogix-PHP-SDK",
            "test",
            true
        );
    }

    public function test_get_buffer_size()
    {
        $this->assertTrue(is_numeric(self::$logger->get_buffer_size()));
        $this->assertGreaterThanOrEqual(0, self::$logger->get_buffer_size());
    }

    public function test__construct()
    {
        $coralogix_logger = new CoralogixLogger(
            getenv("PRIVATE_KEY"),
            "Coralogix-PHP-SDK",
            "test",
            true
        );
        $this->assertTrue(true);
        unset($coralogix_logger);
    }

    public function test_set_debug_mode()
    {
        $this->assertTrue(CoralogixLogger::set_debug_mode(true));
    }

    public function test_log_with_default_category()
    {
        self::$logger->log(Severity::INFO, "Test message with default category");
        $this->assertTrue(true);
    }

    public function test_log_with_custom_category()
    {
        self::$logger->log(Severity::ERROR, "Test error message with custom category", "Vulnerability");
        $this->assertTrue(true);
    }

    public function test_log_with_custom_thread_id()
    {
        self::$logger->log(Severity::VERBOSE, "Test verbose message with user defined thread ID", NULL, "", "", "1234567");
        $this->assertTrue(true);
    }

    public function test_debug()
    {
        self::$logger->debug("Test debug message");
        $this->assertTrue(true);
    }

    public function test_verbose()
    {
        self::$logger->verbose("Test verbose message");
        $this->assertTrue(true);
    }

    public function test_info()
    {
        self::$logger->info("Test info message");
        $this->assertTrue(true);
    }

    public function test_warning()
    {
        self::$logger->warning("Test warning message");
        $this->assertTrue(true);
    }

    public function test_error()
    {
        self::$logger->error("Test error message");
        $this->assertTrue(true);
    }

    public function test_critical()
    {
        self::$logger->critical("Test critical message");
        $this->assertTrue(true);
    }

    public function test_flush_messages()
    {
        self::$logger->flush_messages();
        $this->assertTrue(true);
        $this->assertEquals(0, self::$logger->get_buffer_size());
    }
}
