<?php

/**
 * UserSeederService
 *
 * PHP version 8.1
 *
 * @category UserSeederService
 * @package  App\Http\Services\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Seeder\UserSeederRepository;
use App\Enum\UserStatusEnum;
use Carbon\Carbon;
use Faker\Factory as Faker;

/**
 * UserSeeder Services
 *
 * PHP version 8.1
 *
 * @category UserSeederService
 * @package  App\Http\Services\Seeder
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
class UserSeederService
{
    /**
     * Create a instance for User model.
     *
     * @param UserSeederRepository $userSeederRepository inject repo
     * @param Faker                $faker                inject facade
     *
     * @return void
     */
    public function __construct(
        protected UserSeederRepository $userSeederRepository,
        protected Faker $faker
    ) {
    }

    /**
     * Create users
     *
     * @param array  $userData users data
     * @param string $password user password
     * @param int    $userType user role
     *
     * @author meet.panchal
     * @return bool
     */
    public function createUser(array $userData, string $password, int $userType): bool
    {
        $faker = $this->faker->create();
        $checkUser = [];
        foreach ($userData as $item) {
            $checkUserExists = $this->userSeederRepository->checkEmailExists(
                $item["email"]
            );

            array_push($checkUser, !(bool) $checkUserExists);

            if (empty($checkUserExists)) {
                $item["password"] = Hash::make($password);
                $item["role_id"] = $userType;
                $item["status"] = UserStatusEnum::ACTIVE->value;
                $item["created_by"] = $faker->randomDigit();
                $item['email_verified_at'] = Carbon::now();
                $this->userSeederRepository->createUsers($item, $userType);
            }
        }
        return in_array(true, $checkUser);
    }
}
