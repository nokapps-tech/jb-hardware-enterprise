<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @property $id
 * @property $product_code
 * @property $sku
 * @property $name
 * @property $product_category_id
 * @property $description
 * @property $price
 * @property $cost
 * @property $stock
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property ProductCategory $productCategory
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['product_code', 'sku', 'name', 'product_category_id', 'description', 'price', 'cost', 'stock'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo(\App\Models\ProductCategory::class, 'product_category_id', 'id');
    }
    
}
