<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProductStockLow;
use App\Models\User;

/**
 * Class Product
 *
 * @property $id
 * @property $product_code
 * @property $name
 * @property $product_category_id
 * @property $notes
 * @property $price
 * @property $cost
 * @property $size
 * @property $unit
 * @property $quantity
 * @property $threshold
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property ProductCategory $productCategory
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model implements Auditable
{
    use SoftDeletes;
    use Notifiable, AuditableTrait;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['product_code', 'name', 'product_category_id', 'notes', 'price', 'cost', 'size', 'unit', 'quantity', 'threshold'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo(\App\Models\ProductCategory::class, 'product_category_id', 'id');
    }

    protected static function booted()
    {
        static::updated(function ($product) {
            if ($product->quantity <= $product->threshold && $product->getOriginal('quantity') > $product->threshold) {
                $admins = User::role(['system-administrator', 'developer'])->get();
                Notification::send($admins, new ProductStockLow($product));
            }
        });
    }
    
}
