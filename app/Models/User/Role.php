<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'roles';

    protected $fillable = [
        'role',
        'created_by'
    ];

    public function createdBy(): BelongsTo {return $this->belongsTo(User::class, 'created_by', 'id', 'createdRoles'); }
    public function users(): BelongsToMany { return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id', 'id', 'id', 'roles')->withTimestamps(); }
    public function permissions(): BelongsToMany { return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id', 'id', 'id', 'roles')->withTimestamps(); }
}
