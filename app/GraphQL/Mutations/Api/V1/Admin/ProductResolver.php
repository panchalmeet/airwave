<?php

/**
 * Product resolver for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Mutations\Api\V1\Admin;

use App\Http\Services\Api\V1\Admin\ProductService;
use App\Http\Services\GraphqlResService;

/**
 * Class ProductResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class ProductResolver
{   
    /**
     * Constructor for dependency injection
     *
     * @param ProductService    $productService    inject service
     * @param GraphqlResService $graphqlResService inject service
     */
    public function __construct(
        protected ProductService   $productService,
        protected GraphqlResService $graphqlResService,
    ) {
    }

    /**
     * For Create product
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     *
     * @return array
     */
    public function __invoke($_, array $args) : array
    {
        try {
            $data = $this->productService->createProduct($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'PRODUCT_CREATED',
                data:$data
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Edit product
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function edit($_, array $args) : array
    {
        try {
            $data = $this->productService->editProduct($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'PRODUCT_UPDATED',
                data:$data
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Delete product
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function delete($_, array $args) : array
    {
        try {
            $data = $this->productService->deleteProduct($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'PRODUCT_DELETED',
                data:$data
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }
}
