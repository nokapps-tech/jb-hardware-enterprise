<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Supplier
 *
 * @property $id
 * @property $name
 * @property $segment
 * @property $type
 * @property $email
 * @property $phone
 * @property $contact_id
 * @property $address
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Contact $contact
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supplier extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'segment', 'type', 'email', 'phone', 'contact_id', 'address'];

    // Predefined choices
    public const TYPES = [
        'manufacturer',
        'distributor',
        'wholesaler',
        'retailer',
    ];

    public const SEGMENTS = [
        'raw_materials',
        'office_supplies',
        'equipment',
        'services',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id', 'id');
    }
    
}
