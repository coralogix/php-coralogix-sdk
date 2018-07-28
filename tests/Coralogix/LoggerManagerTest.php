<?php

namespace Coralogix;


use Coralogix\Constants;
use Coralogix\Severity;
use Coralogix\LoggerManager;


class LoggerManagerTest extends \PHPUnit\Framework\TestCase
{
    private static $logger_manager;

    public static function setUpBeforeClass()
    {
        self::$logger_manager = new LoggerManager(
            array(
                "privateKey" => getenv("PRIVATE_KEY"),
                "applicationName" => "Coralogix-PHP-SDK",
                "subsystemName" => "test"
            ),
            true
        );
    }

    public function test_setup_with_wrong_params()
    {
        $logger_manager = new LoggerManager(
            array(),
            true
        );
        $this->assertTrue(true);
        unset($logger_manager);
    }

    public function test_add_logline()
    {
        self::$logger_manager->add_logline("Test log message", Severity::INFO);
        $this->assertGreaterThan(0, self::$logger_manager->get_buffer_size());
    }

    public function test_add_logline_with_severity_out_range()
    {
        self::$logger_manager->add_logline("Test log message", 15);
        $this->assertGreaterThan(0, self::$logger_manager->get_buffer_size());
    }

    public function test_add_logline_with_large_message()
    {
        $buffer_size = self::$logger_manager->get_buffer_size();
        self::$logger_manager->add_logline(
            str_repeat("0", Constants::MAX_LOG_CHUNK_SIZE),
            Severity::INFO
        );
        $this->assertEquals(
            $buffer_size,
            self::$logger_manager->get_buffer_size()
        );
    }

    public function test_get_buffer_size()
    {
        $this->assertGreaterThanOrEqual(0, self::$logger_manager->get_buffer_size());
    }

    public function test_get_buffer_size_in_bytes()
    {
        $this->assertGreaterThanOrEqual(0, self::$logger_manager->get_buffer_size(true));
    }

    public function test_flush()
    {
        self::$logger_manager->flush();
        $this->assertTrue(true);
    }

    public function test_stop()
    {
        self::$logger_manager->stop();
        $this->assertTrue(true);
    }

    public function test_msg2str_with_string()
    {
        $test_message = "1234";
        $this->assertEquals(
            $test_message,
            self::$logger_manager->msg2str($test_message)
        );
    }

    public function test_msg2str_with_array()
    {
        $test_message = array("foo" => "bar", "color" => "red");
        $this->assertEquals(
            json_encode($test_message, JSON_UNESCAPED_UNICODE),
            self::$logger_manager->msg2str($test_message)
        );
    }

    public function test_msg2str_with_object()
    {
        $test_message = new \stdClass();
        $test_message->foo = "bar";
        $this->assertEquals(
            json_encode($test_message, JSON_UNESCAPED_UNICODE),
            self::$logger_manager->msg2str($test_message)
        );
    }

    public function test_msg2str_with_integer()
    {
        $test_message = 1234;
        $this->assertEquals(
            (string)$test_message,
            self::$logger_manager->msg2str($test_message)
        );
    }

    public function test_msg2str_with_null()
    {
        $this->assertEquals(
            "",
            self::$logger_manager->msg2str(NULL)
        );
    }

    public function test_send_bulk()
    {
        $reflection = new \ReflectionClass(get_class(self::$logger_manager));
        $method = $reflection->getMethod("send_bulk");
        $method->setAccessible(true);

        self::$logger_manager->add_logline("Test log message", Severity::INFO);
        $method->invokeArgs(self::$logger_manager, array("time_sync" => true));

        $this->assertTrue(true);
    }

    public function test_send_bulk_empty()
    {
        $reflection = new \ReflectionClass(get_class(self::$logger_manager));
        $method = $reflection->getMethod("send_bulk");
        $method->setAccessible(true);
        $method->invokeArgs(self::$logger_manager, array("time_sync" => true));
        $this->assertTrue(true);
    }

    public function test_send_bulk_big()
    {
        $reflection = new \ReflectionClass(get_class(self::$logger_manager));
        $method = $reflection->getMethod("send_bulk");
        $method->setAccessible(true);

        for ($i = 0; $i < 2; $i++) {
            self::$logger_manager->add_logline(str_repeat("T", 1024 ** 2), Severity::INFO);
        }
        $method->invokeArgs(self::$logger_manager, array("time_sync" => true));

        $this->assertTrue(true);
    }
}
