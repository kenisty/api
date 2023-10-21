<?php declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
{
    private const EMAIL_REQUIRED_VALIDATION_FAILED = 'auth.login.failed.request.email.required';
    private const EMAIL_EXISTS_VALIDATION_FAILED = 'auth.login.failed.request.email.exists';
    private const EMAIL_EMAIL_VALIDATION_FAILED = 'auth.login.failed.request.email.email';

    private const PASSWORD_REQUIRED_VALIDATION_FAILED = 'auth.login.failed.request.password.required';
    private const PASSWORD_STRING_VALIDATION_FAILED = 'auth.login.failed.request.password.string';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'email' => [
                'required' => trans(self::EMAIL_REQUIRED_VALIDATION_FAILED),
                'email' => trans(self::EMAIL_EMAIL_VALIDATION_FAILED),
                'exists' => trans(self::EMAIL_EXISTS_VALIDATION_FAILED),
            ],
            'password' => [
                'required' => trans(self::PASSWORD_REQUIRED_VALIDATION_FAILED),
                'string' => trans(self::PASSWORD_STRING_VALIDATION_FAILED),
            ],
        ];
    }
}
