<?php
/**
 * Request
 * PHP version 8.1
 *
 * @category Edit_Product
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Validators\Api\V1\Admin;

use Nuwave\Lighthouse\Validation\Validator;

/**
 * Create class for edit product validation
 *
 * @category Edit_Product
 * @package  App/GraphQL/Validators/Api/V1
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class EditProductValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'uuid'           => ['required', 'exists:products,uuid'],
            'cat_uuid'       => ['required', 'exists:categories,uuid'],
            'sub_cat_uuid'   => ['required', 'exists:sub_categories,uuid'],
            'name'           => ['required', 'max:100'],
            'price'          => ['required'],
            'main_img'       => ['required', 'max:'.env('IMAGE_UPLOAD_SIZE', '2048'), 'mimes:jpg,jpeg,png'],
            'sec_img'        => ['max:'.env('IMAGE_UPLOAD_SIZE', '2048'), 'mimes:jpg,jpeg,png'],
            'thrd_img'       => ['max:'.env('IMAGE_UPLOAD_SIZE', '2048'), 'mimes:jpg,jpeg,png'],
            'status'         => ['required'],
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
            
            'cat_uuid.required' => trans('validation.custom.uuid.required'),
            'cat_uuid.exists'   => trans('validation.custom.uuid.exists'),

            'sub_cat_uuid.required' => trans('validation.custom.uuid.required'),
            'sub_cat_uuid.exists'   => trans('validation.custom.uuid.exists'),

            'name.required' => trans('validation.custom.product_name.required'),
            'name.max' => trans('validation.custom.product_name.max'),
            
            'price.required' => trans('validation.custom.price.required'),

            'main_img.required' => trans('validation.custom.main_img.required'),
            'main_img.max' => trans('validation.custom.main_img.max'),
            'main_img.mimes' => trans('validation.custom.main_img.mimes'),

            'sec_img.max' => trans('validation.custom.sec_img.max'),
            'sec_img.mimes' => trans('validation.custom.sec_img.mimes'),

            'thrd_img.max' => trans('validation.custom.thrd_img.max'),
            'thrd_img.mimes' => trans('validation.custom.thrd_img.mimes'),

            'status.required' => trans('validation.custom.product_status.required'),
            
        ];
    }
}
