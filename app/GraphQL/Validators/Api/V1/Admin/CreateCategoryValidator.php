<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category Create_Category
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for create category validation
 *
 * @category Create_Category
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class CreateCategoryValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'category_name'   => ['required', 'max:100'],
            'category_slug'   => ['required', 'regex:/^[a-zA-Z\d-]+$/u', 'max:50', 'unique:categories,slug'],
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
