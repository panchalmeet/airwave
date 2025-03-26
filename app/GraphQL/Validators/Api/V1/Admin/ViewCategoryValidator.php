<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category View_Category
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for validate uuid
 *
 * @category View_Category
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class ViewCategoryValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'uuid' => ['required','exists:categories,uuid'],
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
            'uuid.required' => trans('validation.custom.uuid.required'),
            'uuid.exists' => trans('validation.custom.uuid.exists'),
        ];
    }
}
