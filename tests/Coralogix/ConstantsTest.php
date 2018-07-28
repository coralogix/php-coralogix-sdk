<?php

namespace Coralogix;


use Coralogix\Constants;


class ConstantsTest extends \PHPUnit\Framework\TestCase
{
    public function test_max_log_buffer_size()
    {
        $this->assertTrue(is_numeric(Constants::MAX_LOG_BUFFER_SIZE));
        $this->assertGreaterThan(0, Constants::MAX_LOG_BUFFER_SIZE);
    }

    public function test_max_log_chunk_size()
    {
        $this->assertTrue(is_numeric(Constants::MAX_LOG_CHUNK_SIZE));
        $this->assertGreaterThan(0, Constants::MAX_LOG_CHUNK_SIZE);
    }

    public function test_normal_send_speed_interval()
    {
        $this->assertGreaterThan(0, Constants::NORMAL_SEND_SPEED_INTERVAL);
    }

    public function test_fast_send_speed_interval()
    {
        $this->assertGreaterThan(0, Constants::FAST_SEND_SPEED_INTERVAL);
    }

    public function test_coralogix_log_url()
    {
        $this->assertTrue(is_string(Constants::CORALOGIX_LOG_URL));
    }

    public function test_coralogix_time_delta_url()
    {
        $this->assertTrue(is_string(Constants::CORALOGIX_TIME_DELTA_URL));
    }

    public function test_time_delay_timeout()
    {
        $this->assertTrue(is_numeric(Constants::TIME_DELAY_TIMEOUT));
    }

    public function test_failed_private_key()
    {
        $this->assertTrue(is_string(Constants::FAILED_PRIVATE_KEY));
        $this->assertFalse(ctype_space(Constants::FAILED_PRIVATE_KEY));
    }

    public function test_no_app_name()
    {
        $this->assertTrue(is_string(Constants::NO_APP_NAME));
        $this->assertFalse(ctype_space(Constants::NO_APP_NAME));
    }

    public function test_no_sub_system()
    {
        $this->assertTrue(is_string(Constants::NO_SUB_SYSTEM));
        $this->assertFalse(ctype_space(Constants::NO_SUB_SYSTEM));
    }

    public function test_log_file_name()
    {
        $this->assertTrue(is_string(Constants::LOG_FILE_NAME));
    }

    public function test_http_timeout()
    {
        $this->assertTrue(is_numeric(Constants::HTTP_TIMEOUT));
        $this->assertGreaterThanOrEqual(0, Constants::HTTP_TIMEOUT);
    }

    public function test_http_send_retry_count()
    {
        $this->assertTrue(is_numeric(Constants::HTTP_SEND_RETRY_COUNT));
        $this->assertGreaterThanOrEqual(0, Constants::HTTP_SEND_RETRY_COUNT);
    }

    public function test_http_send_retry_interval()
    {
        $this->assertTrue(is_numeric(Constants::HTTP_SEND_RETRY_INTERVAL));
        $this->assertGreaterThan(0, Constants::HTTP_SEND_RETRY_INTERVAL);
    }

    public function test_coralogix_category()
    {
        $this->assertTrue(is_string(Constants::CORALOGIX_CATEGORY));
        $this->assertFalse(ctype_space(Constants::CORALOGIX_CATEGORY));
    }

    public function test_sync_time_update_interval()
    {
        $this->assertTrue(is_numeric(Constants::SYNC_TIME_UPDATE_INTERVAL));
        $this->assertGreaterThan(0, Constants::SYNC_TIME_UPDATE_INTERVAL);
    }
}
