<?php

/**
 * Service for admin authenticate
 *
 * PHP version 8.1
 *
 * @category AdminLoginService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Enum\UserStatusEnum;
use App\Enum\UserRoleEnum;

/**
 * Perform Login related operation
 *
 * PHP version 8.1
 *
 * @category AdminLoginService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class AdminLoginService
{
    /**
     * Create a loggingService instance.
     *
     * @param User $userModel Inject model
     *
     * @author meet.panchal
     *
     * @return void
     */
    public function __construct(
        protected User $userModel,
    ) {
    }

    /**
     * Check user credentials
     *
     * @param array $input Input data
     *
     * @author meet.panchal
     *
     * @return mixed
     */
    public function login(array $input): mixed
    {
        $credentials = ['email'    => $input['email'],
                        'password' => $input['password'],
                        'role_id'  => UserRoleEnum::ADMIN->value,
                        'status'   => UserStatusEnum::ACTIVE->value
                    ];


        if (Auth::attempt($credentials)) {
            $loginUser = Auth::user();
            $loginUser->revokeTokens();
            $params = $this->buildParams($credentials);
            $token = $this->requestToken($params);
            if (isset($token['error'])) {
                return ['error' => 'PASSPORT_TOKEN_ERROR'];
            }
            
            $loginUser['phone'] = !empty($loginUser['phone'])?$loginUser['phone'] : '';
            $loginUser['first_name'] = !empty($loginUser['first_name'])?$loginUser['first_name'] : '';
            $loginUser['last_name'] = !empty($loginUser['last_name'])?$loginUser['last_name'] : '';
            $loginUser['email'] = !empty($loginUser['email'])?$loginUser['email'] : '';
            $loginUser['status'] = !empty($loginUser['status'])?$loginUser['status'] : '';
            $loginUser['verified'] = !empty($loginUser['verified'])?$loginUser['verified'] : '';
            $loginUser['email_verified_at'] = !empty($loginUser['email_verified_at'])
                ? $loginUser['email_verified_at'] : '';

            return array_merge($token, ['user' => $loginUser]);
        }

        return $this->emailExists($input);
    }

    /**
     * Check mobile number exist
     *
     * @param array $input condition
     *
     * @author meet.panchal
     * @return mixed
     */
    public function emailExists(array $input) : mixed
    {
        $user = $this->userModel->getUserData(['email'=> $input['email'] ]);
        if (!$user) {
            return ['error' => 'LOGIN_ERROR'];
        }

        //if password does not match then alow throw an Login Error.
        if (!Hash::check($input["password"], $user->password)) {
            return ['error' => 'LOGIN_ERROR'];
        }

        if (empty($user->email_verified_at)) {
            return ['error' => 'ACCOUNT_UNVERIFIED'];
        }

        if ($user->status != UserStatusEnum::ACTIVE->value) {
            return ['error' => 'INACTIVATE_ACCOUNT'];
        }

        return ['error' => 'LOGIN_ERROR'];
    }

    /**
     * Build request params
     *
     * @param array $credentials manage email and password
     *
     * @author meet.panchal
     * @return array
     */
    public function buildParams(array $credentials): array
    {
        $params =[
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'scope' => '*'
        ];
        return $params;
    }

    /**
     * Request access Token
     *
     * @param array $params for creating req
     *
     * @author meet.panchal
     * @return mixed
     */
    public function requestToken($params): mixed
    {
        $request = Request::create(
            'oauth/token',
            'POST',
            $params,
            [],
            [],
            [
            'HTTP_Accept' => 'application/json',
            ]
        );
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            return ['error'=> json_encode($decodedResponse)];
        }
        return $decodedResponse;
    }

}
