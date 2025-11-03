<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Branch
 *
 * @property $id
 * @property $name
 * @property $contact_number
 * @property $address
 * @property $description
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Transaction[] $transactions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Branch extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'contact_number', 'address', 'description'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'id', 'branch_id');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'id', 'branch_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }
}
