<?php

/**
 * CategoryListResolver for fetch data
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Queries\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Queries\Api\V1\Admin;

use App\Http\Services\Api\V1\Admin\CategoryService;
use App\Http\Services\GraphqlResService;

/**
 * Class CategoryListResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Queries\Api\V1\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class CategoryListResolver
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
     * For fetch category data
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        try {
            $filterArray = [];
            $filterArray['offset'] = isset($args['offset']) ? $args['offset'] : 0;
            $filterArray['limit'] = isset($args['limit']) ? $args['limit'] : 0;
            $filterArray['query'] = isset($args['query']) ? $args['query'] : '';
            $filterArray['sort_order'] = !empty($args['sort_order']) ? $args['sort_order'] : 'DESC';
            $filterArray['sort_column'] = !empty($args['sort_column']) ? $args['sort_column'] : 'id';

            $response = $this->categoryService->getList($filterArray);

            return $this->graphqlResService->success(
                'RECORD_FETCH',
                $response['pagination'],
                $response['data']
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);
        }
    }

    /**
     * For fetch detail category data
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     * @return array
     */
    public function view($_, array $args): array
    {
        $response = $this->categoryService->viewCategory($args);
        if (isset($response['error'])) {
            return $this->graphqlResService->error(message: $response['error'], code: 422);
        }

        return $this->graphqlResService->success(message: 'LIST_SUCCESS', data: $response);
    }

}
