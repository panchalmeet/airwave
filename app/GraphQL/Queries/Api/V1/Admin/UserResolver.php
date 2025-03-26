<?php

/**
 * User query resolver
 *
 * PHP version 8.1
 * @category GraphQL
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Queries\Api\V1\Admin;

use App\Http\Services\GraphqlResService;
use App\Models\User;

/**
 * Class UserResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 *
 */
final class UserResolver
{
    /**
     * User login constructor.
     *
     * @param object GraphqlResService $graphqlResService Inject service
     * @param object User              $user              Inject model
     */
    public function __construct(protected GraphqlResService $graphqlResService)
    {
    }

    /**
     * Default function
     *
     * @param  null  $_    default
     * @param  array  $args request parameters
     * @return mixed
     * @SuppressWarnings("unused")
     * @SuppressWarnings("CamelCase")
     * @SuppressWarnings("ShortVariable")
     */
    public function __invoke($_, array $args)
    {
        try {
            $data = $this->user::find($args['id']);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(message:$data['error']);
            }

            return $this->graphqlResService->success(
                message:'USER_LOGIN',
                data:$data
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR');
        }
    }
}
