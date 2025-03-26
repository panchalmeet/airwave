<?php
/**
 * Create Seeder for Admin user
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;
use App\Http\Services\Seeder\UserSeederService;
use App\Enum\UserRoleEnum;

/**
 * Create Seeder for Admin user
 *
 * PHP version 8.1
 *
 * @category Genereal
 * @package  Database\Seeders
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Constructor.
     *
     * @param UserSeederService $userSeederService inject Repository
     * @param Faker             $faker             faker facade
     */
    public function __construct(
        protected UserSeederService $userSeederService,
        protected Faker $faker
    ) {
    }

    // Admin use details
    public $adminUserArr = [
        [
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@airwave.com',
            'role_id' => 1,
            'status' => 1
        ]
    ];

    /**
     * Run the database seeds for create AdminUser.
     * 
     * @return bool
     */
    public function run(): bool
    {
        $password = 'Admin@123';
        $seederResponse = $this->userSeederService->createUser(
            $this->adminUserArr,
            $password,
            UserRoleEnum::ADMIN->value
        );
        if ($seederResponse === true) {
            $this->command->info("Admin user created successfully! Please note and keep below password safe.");
            $this->command->info("Password :- " . $password);
            return true;
        }
        $this->command->info("Admin users already created through seeder.");
        return true;
    }
}
