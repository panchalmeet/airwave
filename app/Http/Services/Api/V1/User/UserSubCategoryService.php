<?php

/**
 * Service for handling sub category related operations
 *
 * PHP version 8.1
 *
 * @category UserSubCategoryService
 * @package  App\Http\Services\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\User;

use App\Enum\SubCategoryStatusEnum;
use App\Enum\UserRoleEnum;
use App\Repositories\Api\V1\Admin\SubCategoryRepository;
use App\Repositories\Api\V1\Admin\CategoryRepository;
use App\Http\Helpers\Api\CommonTrait;
use DB;

/**
 * Category Service for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category UserSubCategoryService
 * @package  App\Http\Services\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class UserSubCategoryService
{
    use CommonTrait;

    protected $subCategoryStatusEnum;
    /**
     * Create a sub category service instace
     *
     * @param SubCategoryRepository $subCatRepo   Inject Repo
     * @param CategoryRepository    $categoryRepo Inject Repo
     *
     * @author meet.panchal
     * @return void
     */
    public function __construct(
        protected SubCategoryRepository $subCatRepo,
        protected CategoryRepository    $categoryRepo,
    ) {
        $this->subCategoryStatusEnum = SubCategoryStatusEnum::getCases();
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
                $data[$key]['category_uuid'] = $value->category->uuid;
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
}
