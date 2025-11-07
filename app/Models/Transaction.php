<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Transaction
 *
 * @property $id
 * @property $transaction_number
 * @property $branch_id
 * @property $name
 * @property $product_id
 * @property $type
 * @property $quantity
 * @property $description
 * @property $notes
 * @property $order_date
 * @property $status
 * @property $created_by
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Branch $branch
 * @property User $user
 * @property Product $product
 * @property Supplier $supplier
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Transaction extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['transaction_number', 'branch_id', 'name', 'product_id', 'type', 'quantity', 'description', 'notes', 'order_date', 'status', 'created_by'];

    public const TYPES = [
        'In',
        'Out',
    ];

    public const STATUSES = [
        'Pending',
        'Completed',
        'Cancelled',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
    
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
