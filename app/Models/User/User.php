<?php declare(strict_types=1);

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Church\Church;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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

    /**
     * @return HasMany<Church>
     */
    public function createdChurches(): HasMany
    {
        return $this->hasMany(Church::class, 'created_by');
    }
}
