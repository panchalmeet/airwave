<?php

/**
 * Service for handling product related operations
 *
 * PHP version 8.1
 *
 * @category ProductService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\Admin;

use App\Enum\ProductStatusEnum;
use App\Enum\TopProductEnum;
use App\Enum\UserRoleEnum;
use App\Repositories\Api\V1\Admin\ProductRepository;
use App\Repositories\Api\V1\Admin\CategoryRepository;
use App\Repositories\Api\V1\Admin\SubCategoryRepository;
use App\Http\Services\UploadFileService;
use App\Http\Helpers\Api\CommonTrait;
use DB;
use File;
use URL;

/**
 * Product Service for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category ProductService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class ProductService
{
    use CommonTrait;

    protected $productStatusEnum;
    protected $topProductEnum;
    /**
     * Create a product service instace
     *
     * @param ProductRepository     $productRepo       Inject Repo
     * @param CategoryRepository    $categoryRepo      Inject Repo
     * @param SubCategoryRepository $subCategoryRepo   Inject Repo
     * @param UploadFileService     $uploadFileService Inject Service
     *
     * @author meet.panchal
     * @return void
     */
    public function __construct(
        protected ProductRepository     $productRepo,
        protected CategoryRepository    $categoryRepo,
        protected SubCategoryRepository $subCategoryRepo,
        protected UploadFileService     $uploadFileService,
    ) {
        $this->productStatusEnum = ProductStatusEnum::getCases();
        $this->topProductEnum    = TopProductEnum::getCases();
    }

    /**
     * Create product preparing data for insert
     *
     * @param array $input request
     *
     * @author meet.panchal
     * @return object|array
     */
    public function createProduct(array $input): object | array
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }

            //prepare data
            $input['category_id']     = $this->categoryRepo->findByUuid($input['cat_uuid'])->id;
            $input['sub_category_id'] = $this->subCategoryRepo->findByUuid(
                $input['sub_cat_uuid'])->id;
            $input['status']          = $this->getEnumValue($this->productStatusEnum, $input['status']);
            $input['top_product']     = $this->getEnumValue($this->topProductEnum, $input['top_product']);
            $input['created_by']      = auth()->user()->id;
            $input['updated_by']      = auth()->user()->id;

            $product                  = $this->productRepo->create($input);

            //file upload operation
            if (!$product->exists()) {
                return ['error' => 'ERROR'];
            }
            $updateProductArr = $this->uploadProductFiles($input, $product);

            //update image name to table
            $this->productRepo->update($updateProductArr, $product->id);
            return $product;
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * Product update images
     *
     * @param  array  $input   request data
     * @param  object $product product object
     * @author meet.panchal
     * @return array
     */
    public function uploadProductFiles($input, $product): array
    {
        $data = [];
        $data['main_img'] = '';
        if (!empty($input['main_img'])) {
            $data['main_img'] = $this->uploadFileService->upload(
                $input['main_img'],
                'main_img',
                $product->id
            );
        }
        
        $data['sec_img'] = '';
        if (!empty($input['sec_img'])) {
            $data['sec_img'] = $this->uploadFileService->upload(
                $input['sec_img'],
                'sec_img',
                $product->id
            );
        }

        $data['thrd_img'] = '';
        if (!empty($input['thrd_img'])) {
            $data['thrd_img'] = $this->uploadFileService->upload(
                $input['thrd_img'],
                'thrd_img',
                $product->id
            );
        }
        return $data;
    }

    /**
     * Update product update images
     *
     * @param  array  $input   request data
     * @param  object $product product object
     * @author meet.panchal
     * @return array
     */
    public function updateProductFiles($input, $product): array
    {
        $data = [];
        $data['main_img'] = '';
        if (!empty($input['main_img'])) {
            if (!empty($product->main_img)) {
                $this->uploadFileService->deleteFile(
                    $product->main_img,
                    'main_img',
                    $product->id
                );
            }
            $data['main_img'] = $this->uploadFileService->upload(
                $input['main_img'],
                'main_img',
                $product->id
            );
        }
        
        $data['sec_img'] = '';
        if (!empty($input['sec_img'])) {
            if (!empty($product->sec_img)) {
                $this->uploadFileService->deleteFile(
                    $product->sec_img,
                    'sec_img',
                    $product->id
                );
            }
            $data['sec_img'] = $this->uploadFileService->upload(
                $input['sec_img'],
                'sec_img',
                $product->id
            );
        }

        $data['thrd_img'] = '';
        if (!empty($input['thrd_img'])) {
            if (!empty($product->thrd_img)) {
                $this->uploadFileService->deleteFile(
                    $product->thrd_img,
                    'thrd_img',
                    $product->id
                );
            }
            $data['thrd_img'] = $this->uploadFileService->upload(
                $input['thrd_img'],
                'thrd_img',
                $product->id
            );
        }
        return $data;
    }

    /**
     * Edit product preparing data for update
     *
     * @param  array $input edit request data
     * @author meet.panchal
     * @return int|array
     */
    public function editProduct(array $input)
    {
        try {
            if (auth()->user()->role_id != UserRoleEnum::ADMIN->value) {
                return ['error' => 'UNAUTHORIZED_ACCESS'];
            }
            $product   = $this->productRepo->findByUuid($input['uuid']);
            $productId = $product->id;

            //prepare data
            $input['category_id']     = $this->categoryRepo->findByUuid($input['cat_uuid'])->id;
            $input['sub_category_id'] = $this->subCategoryRepo->findByUuid(
                $input['sub_cat_uuid'])->id;
            $input['status']          = $this->getEnumValue($this->productStatusEnum, $input['status']);
            $input['top_product']     = $this->getEnumValue($this->topProductEnum, $input['top_product']);
            $input['updated_by']      = auth()->user()->id;
            unset(
                $input['uuid'],
                $input['cat_uuid'],
                $input['sub_cat_uuid'],
            );
            $this->productRepo->update($input, $productId);
            //file upload operation
            $updateProductArr = $this->updateProductFiles($input, $product);

            //update image name to table
            $this->productRepo->update($updateProductArr, $productId);
            return ['Success' => 'SUCCESS'];
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }

    /**
     * View product
     *
     * @param array $params manage uuid of category
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function viewProduct(array $params): array | object
    {
        $product = $this->productRepo->findByUuid($params['uuid']);
        $product->category_name = $product->category->name;
        $product->sub_category_name = $product->subCategory->name;
        
        $product->main_img = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($product->main_img, 'main_img', $product->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($product->main_img, 'main_img', $product->id)) : "";

        $product->sec_img = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($product->sec_img, 'sec_img', $product->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($product->sec_img, 'sec_img', $product->id)) : "";

        $product->thrd_img = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($product->thrd_img, 'thrd_img', $product->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($product->thrd_img, 'thrd_img', $product->id)) : "";

        if (empty($product)) {
            return ['error' => 'NO_RECORD_FOUND'];
        }
        return $product;
    }

    /**
     * Get list of product data
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
            if (!empty($filterArray['top_product'])) {
                $filterArray['top_product'] = $this->getEnumValue($this->topProductEnum, $filterArray['top_product']);
            } else {
                unset($filterArray['top_product']);
            }
            $data = $this->productRepo->fetchList($filterArray);
            
            foreach ($data as $key => $value) {
                $data[$key]['category_uuid']     = $value->category->uuid;
                $data[$key]['category_name']     = $value->category->name;
                $data[$key]['sub_category_uuid'] = $value->subCategory->uuid;
                $data[$key]['sub_category_name'] = $value->subCategory->name;
                
                $data[$key]['main_img'] = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($value->main_img, 'main_img', $value->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($value->main_img, 'main_img', $value->id)) : "";

                $data[$key]['sec_img'] = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($value->sec_img, 'sec_img', $value->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($value->sec_img, 'sec_img', $value->id)) : "";

                $data[$key]['thrd_img'] = file_exists(public_path().($this->uploadFileService->getUploadedFileUrl($value->thrd_img, 'thrd_img', $value->id))) ? URL::asset($this->uploadFileService->getUploadedFileUrl($value->thrd_img, 'thrd_img', $value->id)) : "";
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
     * Delete product
     *
     * @param array $params request
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function deleteProduct(array $params): array | object
    {
        try {
            $product  = $this->productRepo->findByUuid($params['uuid']);
            //Delete media
            $this->uploadFileService->deleteFile(
                    $product->main_img,
                    'main_img',
                    $product->id
                );
            $this->uploadFileService->deleteFile(
                                $product->sec_img,
                                'sec_img',
                                $product->id
                            );
            $this->uploadFileService->deleteFile(
                                $product->thrd_img,
                                'thrd_img',
                                $product->id
                            );
            $response = $this->productRepo->delete($product->id);
            if ($response) {
                return ['success' => 'SUCCESS'];
            }
            return ['error' => 'ERROR'];
        } catch (Exception $e) {
            return ['error' => 'ERROR'];
        }
    }
}
