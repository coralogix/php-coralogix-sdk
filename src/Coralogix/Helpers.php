<?php
/**
 * Coralogix logger helping methods
 *
 * @author Eldar Aliiev <eldar@coralogix.com>
 * @link https://coralogix.com/
 * @copyright Coralogix Ltd. 2018
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Coralogix;


/**
 * Class Helpers
 *
 * Helpers functions for Coralogix logger
 * @package Coralogix
 * @final
 */
final class Helpers
{
    /**
     * Get current package information
     * @access public
     * @static
     * @return array package information
     */
    public static function get_package_info(): array
    {
        return json_decode(file_get_contents(__DIR__ . "/../../composer.json"), true);
    }

    /**
     * Get current package information
     * @access public
     * @static
     * @return string current package version
     */
    public static function get_package_version(): string
    {
        $package_data =self::get_package_info();
        return (isset($package_data["version"]) ? $package_data["version"] : "1.0.0");
    }

    /**
     * Get current machine name
     * @access public
     * @static
     * @return string current machine name
     */
    public static function get_computer_name(): string
    {
        return gethostname();
    }

    /**
     * Get current machine IP-address
     * @access public
     * @static
     * @return string current machine IP-address
     */
    public static function get_computer_address(): string
    {
        return gethostbyname(gethostname());
    }
}