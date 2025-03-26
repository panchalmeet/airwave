<?php

/**
 * Sub Category resolver for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Mutations\Api\V1\Admin;

use App\Http\Services\Api\V1\Admin\SubCategoryService;
use App\Http\Services\GraphqlResService;

/**
 * Class SubCategoryResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class SubCategoryResolver
{   
    /**
     * Constructor for dependency injection
     *
     * @param SubCategoryService $subCategoryService inject service
     * @param GraphqlResService  $graphqlResService  inject service
     */
    public function __construct(
        protected SubCategoryService $subCategoryService,
        protected GraphqlResService  $graphqlResService,
    ) {
    }

    /**
     * For Create sub category
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
            $data = $this->subCategoryService->createSubCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'SUB_CATEGORY_CREATED',
                data:$data
            );
        } catch (Exception $e) {

            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Edit sub category
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function edit($_, array $args) : array
    {
        try {
            $data = $this->subCategoryService->editSubCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'SUB_CATEGORY_UPDATED',
                data:$data
            );
        } catch (Exception $e) {

            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Delete sub category
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function delete($_, array $args) : array
    {
        try {
            $data = $this->subCategoryService->deleteSubCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(message:$data['error'], code:422);
            }

            return $this->graphqlResService->success(message:'SUB_CATEGORY_DELETED', data:$data);
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }
}
