<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category UserLogin
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for set user login validation
 *
 * @category UserLogin
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class AdminLoginInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password'=> ['required'],
        ];
    }
    
    /**
     * Purpose Get custom messages for validator errors.
     *
     * @author meet.panchal
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => __('error.REQUIRED_EMAIL'),
            'email.email' => __('error.INVALID_EMAIL'),
            'password.required' => __('error.REQUIRED_PASSWORD')
        ];
    }
}
