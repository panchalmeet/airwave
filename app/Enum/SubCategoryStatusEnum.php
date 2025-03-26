<?php
 /**
  * SubCategoryStatusEnum
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
 * SubCategoryStatusEnum
 *
 * PHP version 8.1
 *
 * @category Enum
 * @package  App\Enum
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

enum SubCategoryStatusEnum: int
{
    case ACTIVE   = 1;
    case INACTIVE = 0;

    public static function getCases()
    {
        return self::cases();
    }
}
