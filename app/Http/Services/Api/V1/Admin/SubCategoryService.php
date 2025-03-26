<?php

/**
 * Service for handling sub category related operations
 *
 * PHP version 8.1
 *
 * @category SubCategoryService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\Admin;

use App\Enum\SubCategoryStatusEnum;
use App\Enum\UserRoleEnum;
use App\Repositories\Api\V1\Admin\SubCategoryRepository;
use App\Repositories\Api\V1\Admin\CategoryRepository;
use App\Repositories\Api\V1\Admin\ProductRepository;
use App\Http\Helpers\Api\CommonTrait;
use DB;

/**
 * Category Service for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category SubCategoryService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class SubCategoryService
{
    use CommonTrait;

    protected $subCategoryStatusEnum;
    /**
     * Create a sub category service instace
     *
     * @param SubCategoryRepository $subCatRepo   Inject Repo
     * @param CategoryRepository    $categoryRepo Inject Repo
     * @param ProductRepository     $productRepo  Inject Repo
     *
     * @author meet.panchal
     * @return void
     */
    public function __construct(
        protected SubCategoryRepository $subCatRepo,
        protected CategoryRepository    $categoryRepo,
        protected ProductRepository     $productRepo,
    ) {
        $this->subCategoryStatusEnum = SubCategoryStatusEnum::getCases();
    }

    /**
     * Create sub category preparing data for insert
     *
     * @param array $input request
     *
     * @author meet.panchal
     * @return object|array
     */
    public function createSubCategory(array $input): object | array
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }

            //prepare data
            $input['name']        = $input['sub_cat_name'];
            $input['category_id'] = $this->categoryRepo->findByUuid(
                $input['category_uuid']
            )->id;
            $input['slug']        = $input['sub_cat_slug'];
            $input['status']      = $this->getEnumValue($this->subCategoryStatusEnum, $input['sub_cat_status']);
            $input['created_by']  = auth()->user()->id;
            $input['updated_by']  = auth()->user()->id;
            $subCategory          = $this->subCatRepo->create($input);

            return $subCategory;
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * Edit Sub Category preparing data for update
     *
     * @param  array $input edit request data
     * @author meet.panchal
     * @return int|array
     */
    public function editSubCategory(array $input): int | array
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }

            $pkId = $input['sub_cat_id'];
            //prepare data
            $input['name']        = $input['sub_cat_name'];
            $input['category_id'] = $this->categoryRepo->findByUuid(
                $input['category_uuid']
            )->id;
            $input['slug']        = $input['sub_cat_slug'];
            $input['status']      = $this->getEnumValue($this->subCategoryStatusEnum, $input['sub_cat_status']);
            $input['updated_by']  = auth()->user()->id;
            unset(
                $input['uuid'],
                $input['sub_cat_id'],
                $input['directive'],
                $input['sub_cat_name'],
                $input['sub_cat_slug'],
                $input['sub_cat_status'],
                $input['category_uuid'],
            );
            $subCategory = $this->subCatRepo->update($input, $pkId);

            return $subCategory;
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * View sub category
     *
     * @param array $params manage uuid of sub category
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function viewSubCategory(array $params): array | object
    {
        $subCategory = $this->subCatRepo->findByUuid($params['uuid']);
        if (empty($subCategory)) {
            return ['error' => 'NO_RECORD_FOUND'];
        }
        return $subCategory;
    }

    /**
     * Get list of sub categories data
     *
     * @param array $filterArray request params
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function getList(array $filterArray)
    {
        try {
            $data = $this->subCatRepo->fetchList($filterArray);

            //Prepare data for listing
            foreach ($data as $key => $value) {
                $data[$key]['category_name'] = $value->category->name;
            }
            
            $response                       = [];
            $response['data']               = $data->items();
            $response['pagination']         = [
                'total_count' => $data->total(),
                'limit'       => $filterArray['limit'],
                'offset'      => $filterArray['offset'],
            ];
            return $response;
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * Delete sub category
     *
     * @param array $params request object
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function deleteSubCategory(array $params): array | object
    {
        try {
            $subCategory = $this->subCatRepo->findByUuid($params['uuid']);
            
            $chkProduct = $this->productRepo->find(['sub_category_id' => $subCategory->id]);
            if (!empty($chkProduct)) {
                return ['error' => 'SUB_CATEGORY_DELETE_ERROR_PRODUCT'];
            }

            $response = $this->subCatRepo->delete($subCategory->id);
            if ($response) {
                return ['success' => 'SUCCESS'];
            }
            return ['error' => 'ERROR'];
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }
}
