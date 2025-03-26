<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category Edit_Category
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for edit category validation
 *
 * @category Edit_Category
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class EditCategoryValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'uuid'            => ['required', 'exists:categories,uuid'],
            'category_name'   => ['required', 'max:100'],
            'category_slug'   => ['required', 'regex:/^[a-zA-Z\d-]+$/u', 'max:50', 'unique:categories,slug,'.$this->arg('cat_id')],
            'category_image'  => ['required', 'max:'.env('IMAGE_UPLOAD_SIZE', '2048'), 'mimes:jpg,jpeg,png'],
            'category_status' => ['required'],
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
            'uuid.required'      => trans('validation.custom.uuid.required'),
            'uuid.exists'        => trans('validation.custom.uuid.exists'),

            'category_name.required' => trans('validation.custom.category_name.required'),
            'category_name.max' => trans('validation.custom.category_name.max'),

            'category_slug.required' => trans('validation.custom.category_slug.required'),
            'category_slug.regex'    => trans('validation.custom.category_slug.regex'),
            'category_slug.max'      => trans('validation.custom.category_slug.max'),
            'category_slug.unique'   => trans('validation.custom.category_slug.unique'),
            
            'category_image.required' => trans('validation.custom.category_image.required'),
            'category_image.max' => trans('validation.custom.category_image.max'),
            'category_image.mimes' => trans('validation.custom.category_image.mimes'),

            'category_status.required' => trans('validation.custom.category_status.required'),
            
        ];
    }
}
