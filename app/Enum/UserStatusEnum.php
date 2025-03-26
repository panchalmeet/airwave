<?php
 /**
  * UserStatusEnum
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
 * UserStatusEnum
 *
 * PHP version 8.1
 *
 * @category Enum
 * @package  App\Enum
 * @author   Meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case DEACTIVATE = 0;

    public static function getCases()
    {
        return self::cases();
    }
}
