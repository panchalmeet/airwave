<?php
/**
 * Repository for product master
 *
 * PHP version 8.1
 *
 * @category ProductManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Repositories\Api\V1\Admin;

use App\Models\Product;

/**
 * Repository for product master
 *
 * @category ProductManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class ProductRepository
{
    /**
     * Constructor to bind model to repo
     *
     * @param object Product $productModel inject model
     *
     * @return void
     */
    public function __construct(
        protected Product $productModel,
    ) {
    }

    /**
     * Create new entry in product master
     *
     * @param array $data input data
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function create(array $data): object
    {
        $product = $this->productModel->create($data);
        return $product;
    }

    /**
     * Update data in product table
     *
     * @param array $data      request data
     * @param int   $productId primary key
     *
     * @author meet.panchal
     *
     * @return int
     */
    public function update(array $data, int $productId): int
    {
        return $this->productModel
            ->find($productId)
            ->update($data);
    }

    /**
     * Find by uuid
     *
     * @param string $uuid uuid
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function findByUuid(string $uuid): object | null
    {
        return $this->productModel
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Find by condition
     *
     * @param array $condition condition array
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function find(array $condition): object | null
    {
        return $this->productModel
            ->where($condition)
            ->first();
    }

    /**
     * Get list of product data
     *
     * @param array $filterArray filter
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function fetchList(array $filterArray): object | null
    {
        $query = $this->productModel;
        
        if (!empty($filterArray['query'])) {
            $query = $query->where(
                function ($query) use ($filterArray) {
                    $query = $query->where(
                        'products.name',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    )->orWhere(
                        'products.price',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    );
                }
            );
        }

        if (!empty($filterArray['sub_category_uuid'])) {
            $query = $query->whereHas('subCategory', function ($q) use ($filterArray) {
                $q->where('uuid', $filterArray['sub_category_uuid']);
            });
        }

        // for multiple fetch products data
        if (!empty($filterArray['product_uuid'])) {
            $query = $query->whereIn('uuid', $filterArray['product_uuid']);
        }
        
        if (isset($filterArray['top_product'])) {
            $query = $query->where('top_product', $filterArray['top_product']);
        }

        if (!empty($filterArray['sort_column'])
            && !empty($filterArray['sort_order'])
        ) {
            $query = $query->orderBy(
                $filterArray['sort_column'],
                $filterArray['sort_order']
            );
        }

        return $query->paginate(
            $filterArray['limit'],
            ['*'],
            'page',
            $filterArray['offset']
        );
    }

    /**
     * Delete product
     *
     * @param int $productId product id
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function delete(int $productId)
    {
        return $this->productModel
            ->find($productId)
            ->delete();
    }
}
