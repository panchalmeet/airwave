<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category Edit_Sub_Category
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for create category validation
 *
 * @category Edit_Sub_Category
 * @package  App/GraphQL/Validators/Api/V1/Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class EditSubCategoryValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'uuid'           => ['required', 'exists:sub_categories,uuid'],
            'category_uuid'  => ['required', 'exists:categories,uuid'],
            'sub_cat_name'   => ['required', 'max:100'],
            'sub_cat_slug'   => ['required', 'regex:/^[a-zA-Z\d-]+$/u', 'max:50', 'unique:sub_categories,slug,'.$this->arg('sub_cat_id')],
            'sub_cat_status' => ['required'],
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
            
            'category_uuid.required' => trans('validation.custom.uuid.required'),
            'category_uuid.exists'   => trans('validation.custom.uuid.exists'),

            'sub_cat_name.required' => trans('validation.custom.sub_cat_name.required'),
            'sub_cat_name.max'      => trans('validation.custom.sub_cat_name.max'),

            'sub_cat_slug.required' => trans('validation.custom.sub_cat_slug.required'),
            'sub_cat_slug.regex'    => trans('validation.custom.sub_cat_slug.regex'),
            'sub_cat_slug.max'      => trans('validation.custom.sub_cat_slug.max'),
            'sub_cat_slug.unique'   => trans('validation.custom.sub_cat_slug.unique'),
        
            'sub_cat_status.required' => trans('validation.custom.sub_cat_status.required'),
            
        ];
    }
}
