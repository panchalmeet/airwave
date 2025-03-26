<?php
/**
 * Handler Common Helper function
 *
 * PHP version 8.1
 *
 * @category Common_Helper
 * @package  App\Http\Helpers\Api
 * @author   Meet Panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Helpers\Api;

/**
 * Handler Question related common Queries
 *
 * @category Common_Helper
 * @package  App\Http\Helpers\Api
 * @author   Meet Panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
trait CommonTrait
{
    /**
     * Used to get the value dynamically
     *
     * @param $enumCase enum Case array
     * @param $name     name of case
     *
     * @author Meet Panchal
     *
     * @return String|Int
     */
    public static function getEnumValue($enumCase, string $name): string
    {
        foreach ($enumCase as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }
        return 'error';
    }

    /**
     * Used to get the value dynamically
     *
     * @param $enumCase enum class
     * @param $value    name of case
     *
     * @author Meet Panchal
     *
     * @return String
     */
    public static function getEnumName($enumCase, $value): string
    {
        foreach ($enumCase as $status) {
            if ($value === $status->value) {
                return $status->name;
            }
        }
        return 'error';
    }
}
