<?php
/**
 * Repository for category master
 *
 * PHP version 8.1
 *
 * @category CategoryManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Repositories\Api\V1\Admin;

use App\Models\Category;

/**
 * Repository for category master
 *
 * @category CategoryManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class CategoryRepository
{
    /**
     * Constructor to bind model to repo
     *
     * @param object Category $categoryModel inject model
     *
     * @return void
     */
    public function __construct(
        protected Category $categoryModel,
    ) {
    }

    /**
     * Create new entry in category master
     *
     * @param array $data input data
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function create(array $data): object
    {
        $category = $this->categoryModel->create($data);
        return $category;
    }

    /**
     * Update data in category table
     *
     * @param array $data  request data
     * @param int   $catId primary key
     *
     * @author meet.panchal
     *
     * @return int
     */
    public function update(array $data, int $catId): int
    {
        return $this->categoryModel
            ->find($catId)
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
        return $this->categoryModel
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Get list of categories data
     *
     * @param array $filterArray filter
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function fetchList(array $filterArray): object | null
    {
        $query = $this->categoryModel;
        
        if (!empty($filterArray['query'])) {
            $query = $query->where(
                function ($query) use ($filterArray) {
                    $query = $query->where(
                        'categories.name',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    )->orWhere(
                        'categories.slug',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    );
                }
            );
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
     * Delete category
     *
     * @param int $catId category id
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function delete(int $catId)
    {
        return $this->categoryModel
            ->find($catId)
            ->delete();
    }
}
