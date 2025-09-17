<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Supplier
 *
 * @property $id
 * @property $company_id
 * @property $contact_person
 * @property $email
 * @property $phone
 * @property $address
 * @property $segment
 * @property $type
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Company $company
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supplier extends Model implements Auditable
{
    use SoftDeletes;
    use Notifiable, AuditableTrait;


    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['company_id', 'contact_person', 'email', 'phone', 'address', 'segment', 'type'];

    // Predefined choices
    public const TYPES = [
        'Manufacturer',
        'Distributor',
        'Wholesaler',
        'Retailer',
    ];

    public const SEGMENTS = [
        'Raw materials',
        'Office supplies',
        'Equipment',
        'Services',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id', 'id');
    }
    
}
