<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'roles';

    protected $fillable = [
        'role'
    ];

    public function users(): BelongsToMany { return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id', 'id', 'id', 'roles')->withTimestamps(); }
}
