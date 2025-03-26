<?php

/**
 * UserRoleEnum
 *
 * PHP version 8.1
 *
 * @category Enum
 * @package  App\Enum
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Enum;

/**
 * UserRoleEnum
 *
 * PHP version 8.1
 *
 * @category Enum
 * @package  App\Enum
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

enum UserRoleEnum: int
{
    case ADMIN = 1;
    case USER  = 2;

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }
        return 'error';
    }
    
    public static function getCases()
    {
        return self::cases();
    }
}
