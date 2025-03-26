<?php

/**
 * Service for add roles data
 *
 * PHP version 8.1
 *
 * @category General
 * @package  App\Http\Services\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Seeder;

use App\Repositories\Seeder\RolesSeederRepository;

/**
 * For get and add records in roles table
 *
 * @category General
 * @package  App\Http\Services\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class RoleSeederService
{
     /**
     * Roles service constructor.
     *
     * @param RolesSeederRepository $roleSeederRepository Inject repo
     */
    public function __construct(
        protected RolesSeederRepository $roleSeederRepository,
    ) {
    }
    
    /**
     * For add new roles
     *
     * @param array $data roles data array
     *
     * @author meet.panchal
     *
     * @return never
     */
    public function add($data)
    {
        $this->roleSeederRepository->create(data:$data);
    }

    /**
     * Check roles exists or not
     *
     * @param string $name for filter condition
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function findRecord($name)
    {
        return $this->roleSeederRepository->findRecord($name);
    }
}
