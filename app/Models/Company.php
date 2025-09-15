<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
/**
 * Class Company
 *
 * @property $id
 * @property $name
 * @property $industry
 * @property $website
 * @property $email
 * @property $phone
 * @property $address
 * @property $postal_code
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Model implements Auditable
{
    use SoftDeletes;
    use Notifiable, AuditableTrait;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'industry', 'website', 'email', 'phone', 'address', 'postal_code'];

}
