<?php

/**
 * Service for handling product related operations
 *
 * PHP version 8.1
 *
 * @category UserProductService
 * @package  App\Http\Services\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services\Api\V1\User;

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
 * @category UserProductService
 * @package  App\Http\Services\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class UserProductService
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
     * Get multiple of product data
     *
     * @param array $filterArray request params
     *
     * @author meet.panchal
     *
     * @return array|object
     */
    public function getProductData(array $filterArray)
    {
        try {
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
}
