<?php

namespace Coralogix;


use Coralogix\DebugLogger;


class DebugLoggerTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        DebugLogger::$debug_mode = true;
    }

    public function test_debug_mode()
    {
        $this->assertTrue(is_bool(DebugLogger::$debug_mode));
        $this->assertTrue(DebugLogger::$debug_mode);
    }

    public function test_log()
    {
        DebugLogger::log('ERROR', 'Test message');
        $this->assertTrue(true);
    }

    public function test_log_with_disabled_debug_mode()
    {
        DebugLogger::$debug_mode = false;
        $this->assertNull(DebugLogger::info("Test info message which will not be displayed"));
        DebugLogger::$debug_mode = true;
    }

    public function test__callStatic()
    {
        DebugLogger::warning('Test warning message');
        $this->assertTrue(true);
    }

    public function test_invalid_severity()
    {
        DebugLogger::warn('Test message with invalid severity');
        $this->assertTrue(true);
    }

    public function test_exception()
    {
        DebugLogger::exception("Test exception message", new \Exception("Test exception"));
        $this->assertTrue(true);
    }
}
