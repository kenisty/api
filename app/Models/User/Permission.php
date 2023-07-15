<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'permissions';

    protected $fillable = [
        'permission',
        'created_by'
    ];

    public function roles(): BelongsToMany { return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id', 'id', 'id', 'permissions')->withTimestamps(); }
    public function users(): Collection { return $this->roles()->with('users')->get()->pluck('users')->flatten()->unique(); }
    public function createdBy(): BelongsTo { return $this->belongsTo(Permission::class, 'created_by', 'id', 'createdPermissions'); }
}
