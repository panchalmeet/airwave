<?php

/**
 * UserProductListResolver for fetch data
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Queries\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\GraphQL\Queries\Api\V1\User;

use App\Http\Services\Api\V1\User\UserProductService;
use App\Http\Services\GraphqlResService;

/**
 * Class UserProductListResolver
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Queries\Api\V1\User
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
final class UserProductListResolver
{
    /**
     * Constructor for dependency injection
     *
     * @param UserProductService $userProductService inject service
     * @param GraphqlResService  $graphqlResService  inject service
     */
    public function __construct(
        protected UserProductService $userProductService,
        protected GraphqlResService  $graphqlResService,
    ) {
    }

    /**
     * For fetch product data
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
            $filterArray['sub_category_uuid'] = isset($args['sub_category_uuid']) ? $args['sub_category_uuid'] : '';
            $filterArray['top_product'] = isset($args['top_product']) ? $args['top_product'] : '';
            $filterArray['sort_order'] = !empty($args['sort_order']) ? $args['sort_order'] : 'DESC';
            $filterArray['sort_column'] = !empty($args['sort_column']) ? $args['sort_column'] : 'id';

            $response = $this->userProductService->getList($filterArray);

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
     * For fetch detail product data
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     * @return array
     */
    public function view($_, array $args): array
    {
        try {
            $response = $this->userProductService->viewProduct($args);
            if (isset($response['error'])) {
                return $this->graphqlResService->error(
                    message: $response['error'],
                    code: 422
                );
            }
            return $this->graphqlResService->success(
                message: 'LIST_SUCCESS',
                data: $response
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);   
        }
    }

    /**
     * For fetch multiple products data
     *
     * @param $_    default argument
     * @param array $args input data
     *
     * @author meet.panchal
     * @return array
     */
    public function getProductsData($_, array $args): array
    {
        try {
            $args['limit']  = 0;
            $args['offset'] = 1;
            $response = $this->userProductService->getProductData($args);
            if (isset($response['error'])) {
                return $this->graphqlResService->error(
                    message: $response['error'],
                    code: 422
                );
            }
            return $this->graphqlResService->success(
                message: 'LIST_SUCCESS',
                data: $response['data']
            );
        } catch (Exception $e) {
            return $this->graphqlResService->error(message:'ERROR', code:500);   
        }
    }

}
