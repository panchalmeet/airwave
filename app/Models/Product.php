<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'uuid',
        'name',
        'part_number',
        'outer_td',
        'outer_bd',
        'inner_td',
        'inner_bd',
        'no_check_valve',
        'no_pass_valves',
        'thread',
        'height',
        'main_img',
        'sec_img',
        'thrd_img',
        'price',
        'status',
        'top_product',
        'created_by',
        'updated_by',
    ];

    /**
     * Generate UUID.
     *
     * @return uuid
     */
    public static function boot()
    {
        parent::boot();
        self::creating(
            function ($model) {
                $model->uuid = (string) Str::uuid();
            }
        );
    }

    /**
    * Belongs to relationship with category
    *
    * @return never
    */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
    * Belongs to relationship with sub category
    *
    * @return never
    */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
