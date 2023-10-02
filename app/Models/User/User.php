<?php declare(strict_types=1);

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\PruneModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use PruneModelTrait;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $fillable = [
        'firstname',
        'lastname',
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

    public function __toString(): string
    {
        return self::class . ' #' . $this->id;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id', 'id', 'id', 'users')->withTimestamps();
    }

    public function createdRoles(): HasMany
    {
        return $this->hasMany(Role::class, 'created_by', 'id');
    }

    public function createdPermissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'created_by', 'id');
    }
}
