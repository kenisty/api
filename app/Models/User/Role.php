<?php

namespace App\Models\User;

use App\Traits\PruneModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $role
 * @property Collection<User> $users
 * @property Collection<Permission> $permissions
 * @property User $createdBy
 */
class Role extends Model
{
    use HasFactory, HasUuids, SoftDeletes, PruneModel;

    protected $connection = 'mysql';
    protected $table = 'roles';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'role',
        'created_by'
    ];

    public function users(): BelongsToMany { return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id', 'id', 'id', 'roles')->withTimestamps(); }
    public function permissions(): BelongsToMany { return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id', 'id', 'id', 'roles')->withTimestamps(); }
    public function createdBy(): BelongsTo { return $this->belongsTo(User::class, 'created_by', 'id', 'createdRoles'); }
}
