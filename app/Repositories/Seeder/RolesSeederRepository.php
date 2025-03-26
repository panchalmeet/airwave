<?php
/**
 * Repository for roles
 *
 * PHP version 8.1
 *
 * @category General
 * @package  App\Http\Repositories\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Repositories\Seeder;

use App\Models\RoleMaster;

/**
 * This class use for perform roles related curd operations
 *
 * @category General
 * @package  App\Http\Repositories\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class RolesSeederRepository
{
    /**
     *  DBindex seeder constructor.
     *
     * @param object RoleMaster $roleMaster inject model
     */
    public function __construct(
        protected RoleMaster $roleMaster,
    ) {
    }

    /**
     * For add new role
     *
     * @param array data $data role data array
     *
     * @author meet.panchal
     *
     * @return never
     */
    public function create($data)
    {
        $this->roleMaster->create($data);
    }

    /**
     * Find role exists in database or not
     *
     * @param string $name role name search query
     *
     * @author meet.panchal
     *
     * @return int
     */
    public function findRecord($name)
    {
        return $this->roleMaster::
            where('name', 'LIKE', "%{$name}%")->first();
    }
}
