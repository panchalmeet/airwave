<?php
/**
 * Repository for sub category master
 *
 * PHP version 8.1
 *
 * @category SubCategoryManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Repositories\Api\V1\Admin;

use App\Models\SubCategory;

/**
 * Repository for sub category master
 *
 * @category SubCategoryManagement
 * @package  App\Http\Repositories\Admin
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class SubCategoryRepository
{
    /**
     * Constructor to bind model to repo
     *
     * @param object SubCategory $subCategoryModel inject model
     *
     * @return void
     */
    public function __construct(
        protected SubCategory $subCategoryModel,
    ) {
    }

    /**
     * Create new entry in sub category master
     *
     * @param array $data input data
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function create(array $data): object
    {
        $subCategory = $this->subCategoryModel->create($data);
        return $subCategory;
    }

    /**
     * Update data in sub category table
     *
     * @param array $data     request data
     * @param int   $subCatId primary key
     *
     * @author meet.panchal
     *
     * @return int
     */
    public function update(array $data, int $subCatId): int
    {
        return $this->subCategoryModel
            ->find($subCatId)
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
        return $this->subCategoryModel
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
        return $this->subCategoryModel
            ->where($condition)
            ->first();
    }

    /**
     * Get list of sub categories data
     *
     * @param array $filterArray filter
     *
     * @author meet.panchal
     *
     * @return object|null
     */
    public function fetchList(array $filterArray): object | null
    {
        $query = $this->subCategoryModel;
        
        if (!empty($filterArray['query'])) {
            $query = $query->where(
                function ($query) use ($filterArray) {
                    $query = $query->where(
                        'sub_categories.name',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    )->orWhere(
                        'sub_categories.slug',
                        'LIKE',
                        '%' . $filterArray['query'] . '%'
                    );
                }
            );
        }

        if (!empty($filterArray['category_uuid'])) {
            $query = $query->whereHas('category', function ($q) use ($filterArray) {
                $q->where('uuid', $filterArray['category_uuid']);
            });
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
     * Delete sub category
     *
     * @param int $subCatId sub category id
     *
     * @author meet.panchal
     *
     * @return object
     */
    public function delete(int $subCatId)
    {
        return $this->subCategoryModel
            ->find($subCatId)
            ->delete();
    }
}
