<?php

namespace Coralogix;


use Coralogix\Helpers;


class HelpersTest extends \PHPUnit\Framework\TestCase
{

    public function test_get_package_version()
    {
        $this->assertTrue(is_array(Helpers::get_package_info()));
    }

    public function test_get_package_info()
    {
        $package_info = Helpers::get_package_info();
        $this->assertArrayHasKey("version", $package_info);
        $this->assertTrue(is_string($package_info["version"]));
        unset($package_info);
    }

    public function test_get_computer_name()
    {
        $this->assertTrue(is_string(Helpers::get_computer_name()));
        $this->assertEquals(gethostname(), Helpers::get_computer_name());
    }

    public function test_get_computer_address()
    {
        $this->assertTrue(is_string(Helpers::get_computer_address()));
        $this->assertEquals(gethostbyname(gethostname()), Helpers::get_computer_address());
    }
}
