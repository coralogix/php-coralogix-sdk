<?php
/**
 * Coralogix logger severities list
 *
 * @author Eldar Aliiev <eldar@coralogix.com>
 * @link https://coralogix.com/
 * @copyright Coralogix Ltd. 2018
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @version 1.0.0
 * @since 1.0.0
 */

namespace Coralogix;


/**
 * Class Severity
 *
 * List of levels for logs records
 * @package Coralogix
 * @property integer DEBUG debug level
 * @property integer VERBOSE verbose level
 * @property integer INFO info level
 * @property integer WARNING warning level
 * @property integer ERROR error level
 * @property integer CRITICAL critical level
 */
abstract class Severity
{
    const DEBUG = 1;
    const VERBOSE = 2;
    const INFO = 3;
    const WARNING = 4;
    const ERROR = 5;
    const CRITICAL = 6;
}