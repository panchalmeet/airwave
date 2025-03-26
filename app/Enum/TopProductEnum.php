<?php
 /**
  * TopProductEnum
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
 * TopProductEnum
 *
 * PHP version 8.1
 *
 * @category Enum
 * @package  App\Enum
 * @author   Meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

enum TopProductEnum: int
{
    case YES = 1;
    case NO = 0;

    public static function getCases()
    {
        return self::cases();
    }
}
