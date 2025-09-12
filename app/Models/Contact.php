<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Contact
 *
 * @property $id
 * @property $first_name
 * @property $last_name
 * @property $email
 * @property $phone
 * @property $company_id
 * @property $job_title
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Company $company
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Contact extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company_id', 'job_title'];

    protected $appends = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id', 'id');
    }

    public function getNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->last_name,
        ]);

        return implode(' ', $parts) ?: '(No Name)';
    }
    
}
