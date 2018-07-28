<?php

namespace Coralogix;


use Coralogix\Constants;
use Coralogix\Severity;
use Coralogix\HttpSender;


class HttpSenderTest extends \PHPUnit\Framework\TestCase
{
    public function test_timeout()
    {
        $this->assertTrue(is_numeric(HttpSender::$timeout));
        $this->assertGreaterThan(0, HttpSender::$timeout);
    }

    public function test_init()
    {
        HttpSender::init(60);
        $this->assertEquals(60, HttpSender::$timeout);
    }

    public function test_init_with_negative()
    {
        HttpSender::init(-15);
        $this->assertEquals(Constants::HTTP_TIMEOUT, HttpSender::$timeout);
    }

    public function test_send_request()
    {
        $this->assertEquals(
            200,
            HttpSender::send_request(array(
                "privateKey" => getenv("PRIVATE_KEY"),
                "applicationName" => "Coralogix-PHP-SDK",
                "subsystemName" => "test",
                "logEntries" => array(
                    array(
                        "text" => "Test message",
                        "timestamp" => time() * 1000,
                        "severity" => Severity::INFO,
                        "category" => Constants::CORALOGIX_CATEGORY
                    )
                )
            ))
        );
    }

    public function test_send_request_with_invalid_url()
    {
        HttpSender::send_request(array(), "invalid endpoint url");
        $this->assertTrue(true);
    }

    public function test_get_time_sync()
    {
        list($result, $time_delta) = HttpSender::get_time_sync();
        $this->assertTrue($result);
        $this->assertTrue(is_numeric($time_delta));
    }

    public function test_get_time_sync_with_invalid_url()
    {
        list($result, $time_delta) = HttpSender::get_time_sync("invalid endpoint url");
        $this->assertFalse($result);
        $this->assertEquals(0, $time_delta);
    }
}
