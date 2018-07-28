<?php

namespace Coralogix\Handlers;


use Monolog\Logger;
use Coralogix\Severity;
use Coralogix\Handlers\CoralogixMonologHandler;


class CoralogixMonologHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function test_log()
    {
        $logger = new Logger("coralogix_logger");
        $logger->pushHandler(
            new CoralogixMonologHandler(
                getenv("PRIVATE_KEY"),
                "Coralogix-PHP-SDK",
                "test"
            )
        );
        $logger->info("Test message from Coralogix handler for Monolog");
        $this->assertTrue(true);
    }

    public function test_severity_map()
    {
        $this->assertEquals(Severity::DEBUG, CoralogixMonologHandler::severity_map(100));
        $this->assertEquals(Severity::INFO, CoralogixMonologHandler::severity_map(200));
        $this->assertEquals(Severity::WARNING, CoralogixMonologHandler::severity_map(250));
        $this->assertEquals(Severity::WARNING, CoralogixMonologHandler::severity_map(300));
        $this->assertEquals(Severity::ERROR, CoralogixMonologHandler::severity_map(400));
        $this->assertEquals(Severity::CRITICAL, CoralogixMonologHandler::severity_map(500));
        $this->assertEquals(Severity::CRITICAL, CoralogixMonologHandler::severity_map(550));
        $this->assertEquals(Severity::CRITICAL, CoralogixMonologHandler::severity_map(600));
        $this->assertEquals(Severity::DEBUG, CoralogixMonologHandler::severity_map(13));
    }
}
