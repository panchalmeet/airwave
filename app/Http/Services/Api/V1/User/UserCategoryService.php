<?php

/**
 * Service for handling category related operations
 *
 * PHP version 8.1
 *
 * @category UserCategoryService
 * @package  App\Http\Services\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\User;

use App\Enum\CategoryStatusEnum;
use App\Enum\UserRoleEnum;
use App\Repositories\Api\V1\Admin\CategoryRepository;
use App\Http\Services\UploadFileService;
use App\Http\Helpers\Api\CommonTrait;
use DB;
use File;
use URL;

/**
 * Category Service for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category UserCategoryService
 * @package  App\Http\Services\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class UserCategoryService
{
    use CommonTrait;

    protected $categoryStatusEnum;
    /**
     * Create a category service instace
     *
     * @param CategoryRepository $categoryRepo      Inject Repo
     * @param UploadFileService  $uploadFileService Inject Repo
     *
     * @author meet.panchal
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepo,
        protected UploadFileService  $uploadFileService,
    ) {
        $this->categoryStatusEnum = CategoryStatusEnum::getCases();
    }

    /**
     * View category
     *
     * @param array $params manage uuid of category
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function viewCategory(array $params): array | object
    {
        $category = $this->categoryRepo->findByUuid($params['uuid']);
        if (empty($category)) {
            return ['error' => 'NO_RECORD_FOUND'];
        }
        $category->image = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($category->image, 'category', $category->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($category->image, 'category', $category->id)) : "";
        return $category;
    }

    /**
     * Get list of categories data
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
            $data = $this->categoryRepo->fetchList($filterArray);

            foreach ($data as $key => $value) {
                $data[$key]['image'] = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($value->image, 'category', $value->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($value->image, 'category', $value->id)) : "";
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
