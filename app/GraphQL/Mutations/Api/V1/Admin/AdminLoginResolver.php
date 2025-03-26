<?php
/**
 * User login resolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Mutations\Api\V1\Admin;

use App\Http\Services\Api\V1\Admin\AdminLoginService;
use App\Http\Services\GraphqlResService;
use Illuminate\Auth\AuthenticationException;
use Carbon\Carbon;
use Auth;
use App\Enum\UserTypeEnum;

/**
 * Class AdminLoginResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class AdminLoginResolver
{
    /**
     * User login constructor.
     *
     * @param AdminLoginService $adminLoginService Inject service
     * @param GraphqlResService $graphqlResService Inject service
     */
    public function __construct(
        protected AdminLoginService $adminLoginService,
        protected GraphqlResService $graphqlResService,
    ) {
    }

    /**
     * For admin login
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     *
     * @return array
     * @SuppressWarnings("unused")
     * @SuppressWarnings("CamelCase")
     * @SuppressWarnings("ShortVariable")
     */
    public function __invoke($_, array $args) : array
    {
        try {
            $data = $this->adminLoginService->login($args);
            
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }

            return $this->graphqlResService->success(
                message:'LOGIN_SUCCESS',
                data:$data
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For admin logout
     *
     * @param object $rootValue default
     * @param array  $args      params
     *
     * @throws \Exception
     * @author meet.panchal
     * @return array
     * @SuppressWarnings("unused")
     */
    public function logout($rootValue, array $args)
    {
        if (! Auth::guard('api')->check()) {
            throw new AuthenticationException('Not Authenticated', ['api']);
        }
        $user = Auth::guard('api')->user();
        $logData = $this->setLogData($user);
        
        // revoke user's token
        $user->revokeTokens();
        $user->update(['device_token' => null]);
        
        return $this->graphqlResService->success(message:'LOGOUT_SUCCESS');
    }
}
