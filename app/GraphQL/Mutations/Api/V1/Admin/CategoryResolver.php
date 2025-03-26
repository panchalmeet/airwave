<?php

/**
 * Category resolver for handling CRUD operations
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Mutations\Api\V1\Admin;

use App\Http\Services\Api\V1\Admin\CategoryService;
use App\Http\Services\GraphqlResService;

/**
 * Class CategoryResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Mutations\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class CategoryResolver
{   
    /**
     * Constructor for dependency injection
     *
     * @param CategoryService   $categoryService   inject service
     * @param GraphqlResService $graphqlResService inject service
     */
    public function __construct(
        protected CategoryService   $categoryService,
        protected GraphqlResService $graphqlResService,
    ) {
    }

    /**
     * For Create category
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
            $data = $this->categoryService->createCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(
                    message:$data['error'],
                    code:422
                );
            }
            return $this->graphqlResService->success(
                message:'CATEGORY_CREATED',
                data:$data
            );
        } catch (Exception $e) {

            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Edit category
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function edit($_, array $args) : array
    {
        try {
            $data = $this->categoryService->editCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(message:$data['error'], code:422);
            }

            return $this->graphqlResService->success(message:'CATEGORY_UPDATED', data:$data);
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For Delete category
     *
     * @param  $_    default argument
     * @param  array $args input data
     * @author meet.panchal
     * @return array
     */
    public function delete($_, array $args) : array
    {
        try {
            $data = $this->categoryService->deleteCategory($args);
            if (isset($data['error'])) {
                return $this->graphqlResService->error(message:$data['error'], code:422);
            }

            return $this->graphqlResService->success(message:'CATEGORY_DELETED', data:$data);
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }
}
