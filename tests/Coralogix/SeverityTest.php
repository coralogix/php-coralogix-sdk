<?php

namespace Coralogix;


use Coralogix\Severity;


class SeverityTest extends \PHPUnit\Framework\TestCase
{
    public function test_debug()
    {
        $this->assertEquals(1, Severity::DEBUG);
    }

    public function test_verbose()
    {
        $this->assertEquals(2, Severity::VERBOSE);
    }

    public function test_info()
    {
        $this->assertEquals(3, Severity::INFO);
    }

    public function test_warning()
    {
        $this->assertEquals(4, Severity::WARNING);
    }

    public function test_error()
    {
        $this->assertEquals(5, Severity::ERROR);
    }

    public function test_critical()
    {
        $this->assertEquals(6, Severity::CRITICAL);
    }
}
