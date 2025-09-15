<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role as SpatieRole;
/**
 * Class Role
 *
 * @property $id
 * @property $display_text
 * @property $name
 * @property $guard_name
 * @property $description
 * @property $readonly
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property ModelHasRole[] $modelHasRoles
 * @property RoleHasPermission[] $roleHasPermissions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Role extends SpatieRole  implements Auditable
{
    use SoftDeletes;
    use Notifiable, AuditableTrait;

    protected $guard_name = 'web';

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['display_text', 'name', 'guard_name', 'description', 'readonly'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelHasRoles()
    {
        return $this->hasMany(\App\Models\ModelHasRole::class, 'id', 'role_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleHasPermissions()
    {
        return $this->hasMany(\App\Models\RoleHasPermission::class, 'id', 'role_id');
    }
    
}
