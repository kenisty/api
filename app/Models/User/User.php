<?php declare(strict_types=1);

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Attributes\TransferEntity;
use App\Models\Church\Church;
use App\Models\Traits\RequestTransferEntityTrait;
use App\Normalizers\UserNormalizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/v1/auth/register',
    description: 'Request for registering new users in. Returns a status code of 201 if the user was able to successfully register attached with an authentication token.',
    summary: 'A request to register a new user.',
    security: [],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            title: 'UserRegisterReadV1',
            description: 'Request schema for registering a new user V1',
            properties: [
                new OA\Property(property: 'firstname', title: 'Firstname', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                new OA\Property(property: 'lastname', title: 'Lastname', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                new OA\Property(property: 'email', title: 'Email', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                new OA\Property(property: 'password', title: 'Password', type: 'string', maxLength: 255, minLength: 8, nullable: false),
                new OA\Property(property: 'password_confirmation', title: 'Password Confirmation', type: 'string', maxLength: 255, minLength: 8, nullable: false),
            ],
        ),
    ),
    tags: ['Authentication'],
    responses: [
        new OA\Response(
            response: 201,
            description: 'Successfully registered a new user.',
            content: new OA\JsonContent(
                title: 'UserRegisterWriteV1',
                description: 'Response schema for successfully registering a new user V1.',
                properties: [
                    new OA\Property(property: 'message', title: 'Message', type: 'string'),
                    new OA\Property(property: 'user', ref: '#/components/schemas/UserDataV1', title: 'User'),
                ],
            ),
        ),
        new OA\Response(
            response: 422,
            description: 'Failed validation.',
            content: new OA\JsonContent(
                ref: '#/components/schemas/ExceptionV1',
                title: 'ExceptionV1',
                description: 'Response schema for failing registering a new user V1.',
            ),
        ),
    ],
)]
#[OA\Post(
    path: '/v1/auth/login',
    description: 'Request for logging existing users in. Returns a status code of 200 if the user was able to successfully login in attached with an authentication token.',
    summary: 'A request to login a user.',
    security: [],
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            title: 'UserLoginReadV1',
            description: 'Request schema for logging in an existing user V1',
            properties: [
                new OA\Property(property: 'email', title: 'Email', type: 'string', nullable: false),
                new OA\Property(property: 'password', title: 'Password', type: 'string', nullable: false),
            ],
        ),
    ),
    tags: ['Authentication'],
    responses: [
        new OA\Response(
            response: 201,
            description: 'Successfully logged in an existing user.',
            content: new OA\JsonContent(
                title: 'UserLoginWriteV1',
                description: 'Response schema for successfully logging in an existing user V1.',
                properties: [
                    new OA\Property(property: 'message', title: 'Message', type: 'string'),
                    new OA\Property(property: 'user', ref: '#/components/schemas/UserDataV1', title: 'User'),
                ],
            ),
        ),
        new OA\Response(
            response: 422,
            description: 'Failed validation.',
            content: new OA\JsonContent(
                ref: '#/components/schemas/ExceptionV1',
                title: 'ExceptionV1',
                description: 'Response schema for failing logging in an existing user V1.',
            ),
        ),
    ],
)]
#[TransferEntity(normalizer: UserNormalizer::class)]
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use RequestTransferEntityTrait;

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
