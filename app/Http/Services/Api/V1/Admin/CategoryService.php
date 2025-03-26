<?php

/**
 * Service for handling category related operations
 *
 * PHP version 8.1
 *
 * @category CategoryService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\Admin;

use App\Enum\CategoryStatusEnum;
use App\Enum\UserRoleEnum;
use App\Repositories\Api\V1\Admin\CategoryRepository;
use App\Repositories\Api\V1\Admin\ProductRepository;
use App\Repositories\Api\V1\Admin\SubCategoryRepository;
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
 * @category CategoryService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class CategoryService
{
    use CommonTrait;

    protected $categoryStatusEnum;
    /**
     * Create a category service instace
     *
     * @param CategoryRepository    $categoryRepo      Inject Repo
     * @param ProductRepository     $productRepo       Inject Repo
     * @param SubCategoryRepository $subCatRepo        Inject Repo
     * @param UploadFileService     $uploadFileService Inject Repo
     *
     * @author meet.panchal
     * @return void
     */
    public function __construct(
        protected CategoryRepository    $categoryRepo,
        protected ProductRepository     $productRepo,
        protected SubCategoryRepository $subCatRepo,
        protected UploadFileService     $uploadFileService,
    ) {
        $this->categoryStatusEnum = CategoryStatusEnum::getCases();
    }

    /**
     * Create category preparing data for insert
     *
     * @param array $input request
     *
     * @author meet.panchal
     * @return object|array
     */
    public function createCategory(array $input): object | array
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }

            //prepare data
            $input['name']   = $input['category_name'];
            $input['slug']   = $input['category_slug'];
            $input['status'] = $this->getEnumValue($this->categoryStatusEnum, $input['category_status']);
            $input['created_by'] = auth()->user()->id;
            $input['updated_by'] = auth()->user()->id;
            $category = $this->categoryRepo->create($input);

            //file upload operation
            $fileName = '';
            if (!empty($input['category_image'])) {
                $fileName = $this->uploadFileService->upload(
                    $input['category_image'],
                    'category',
                    $category->id
                );
            }

            //update image name to table
             if (!empty($fileName)) {
                $updateCat          = [];
                $updateCat['image'] = $fileName;

                $this->categoryRepo->update($updateCat, $category->id);
            }
            return $category;
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * Edit Category preparing data for update
     *
     * @param  array $input edit request data
     * @author meet.panchal
     * @return int|array
     */
    public function editCategory(array $input): int | array
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }
            // prepare data
            $uuid            = $input['uuid'];
            $input['name']   = $input['category_name'];
            $input['slug']   = $input['category_slug'];
            $input['image']  = $input['category_image'];
            $input['status'] = $this->getEnumValue($this->categoryStatusEnum, $input['category_status']);
            $input['updated_by'] = auth()->user()->id;
            unset(
                $input['directive'],
                $input['cat_id'],
                $input['uuid'],
                $input['category_name'],
                $input['category_slug'],
                $input['category_image'],
                $input['category_status'],
            );

            //checkpoint for record exists or not 
            $category = $this->categoryRepo->findByUuid($uuid);
            if (empty($category)) {
                return ['error' => 'RECORD_NOT_FOUND'];
            }

            //file upload operation
            $fileName = '';
            if (!empty($input['image'])) {
                //delete existing file
                $this->uploadFileService->deleteFile($category->image, 'category', $category->id);
                //upload new file
                $fileName = $this->uploadFileService->upload(
                    $input['image'],
                    'category',
                    $category->id
                );
            }

            if (!empty($fileName)) {
                $input['image'] = $fileName;
            }
            return $this->categoryRepo->update($input, $category->id);
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
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

    /**
     * Delete category
     *
     * @param array $params request object
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function deleteCategory(array $params): array | object
    {
        try {
            $category = $this->categoryRepo->findByUuid($params['uuid']);
            
            $chkProduct = $this->productRepo->find(['category_id' => $category->id]);
            if (!empty($chkProduct)) {
                return ['error' => 'CATEGORY_DELETE_ERROR_PRODUCT'];
            }

            $chkSubCat = $this->subCatRepo->find(['category_id' => $category->id]);
            if (!empty($chkSubCat)) {
                return ['error' => 'CATEGORY_DELETE_ERROR_SUB_CAT'];
            }
            //delete file
            $this->uploadFileService->deleteFile(
                $category->image,
                'category',
                $category->id
            );
            $response = $this->categoryRepo->delete($category->id);
            if ($response) {
                return ['success' => 'SUCCESS'];
            }
            return ['error' => 'ERROR'];
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }
}
