<?php
/**
 * Create Seeder for role master table
 *
 * PHP version 8.1
 *
 * @category Genereal
 * @package  Database\Seeders
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Services\Seeder\RoleSeederService;

/**
 * Create Seeder for role master table
 *
 * PHP version 8.1
 *
 * @category Genereal
 * @package  Database\Seeders
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 * @link     https://brainvire.com
 */
class RoleMasterSeeder extends Seeder
{
    /**
     * Constructor.
     *
     * @param RoleSeederService $roleSeederService inject Service
     */
    public function __construct(
        protected RoleSeederService $roleSeederService,
    ) {
    }

    public $roles = [
        [ 
            'name' => 'Admin',
            'status' => 1
        ],
        [ 
            'name' => 'User',
            'status' => 1
        ],
    ];

    /**
     * Create new role
     *
     * @author meet.panchal
     *
     * @return never
     */
    public function run()
    {
        foreach ($this->roles as $value) {
            $checkRole = $this->roleSeederService->findRecord($value['name']);
            if (!empty($checkRole)) {
                continue;
            }
            $this->roleSeederService->add(data:$value);
        }
    }
}
