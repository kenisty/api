<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany { return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id', 'id', 'id', 'users')->withTimestamps(); }
    public function permissions(): Collection { return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique(); }
    public function createdRoles(): HasMany { return $this->hasMany(Role::class, 'created_by', 'id'); }
    public function createdPermissions(): HasMany { return $this->hasMany(Permission::class, 'created_by', 'id'); }
}
