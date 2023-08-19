<?php

namespace App\Http\Requests\User;

use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    use ResponseTrait;

    private const VALIDATION_FAILED_MESSAGE = 'register.request.fail.message';

    private const FIRST_NAME_REQUIRED_VALIDATION_FAILED = 'register.request.fail.first_name.required.message';
    private const FIRST_NAME_STRING_VALIDATION_FAILED = 'register.request.fail.first_name.string.message';
    private const FIRST_NAME_MIN_VALIDATION_FAILED = 'register.request.fail.first_name.min.message';
    private const FIRST_NAME_MAX_VALIDATION_FAILED = 'register.request.fail.first_name.max.message';

    private const LAST_NAME_REQUIRED_VALIDATION_FAILED = 'register.request.fail.last_name.required.message';
    private const LAST_NAME_STRING_VALIDATION_FAILED = 'register.request.fail.last_name.string.message';
    private const LAST_NAME_MIN_VALIDATION_FAILED = 'register.request.fail.last_name.min.message';
    private const LAST_NAME_MAX_VALIDATION_FAILED = 'register.request.fail.last_name.max.message';

    private const EMAIL_REQUIRED_VALIDATION_FAILED = 'register.request.fail.email.required.message';
    private const EMAIL_UNIQUE_VALIDATION_FAILED = 'register.request.fail.email.unique.message';
    private const EMAIL_EMAIL_VALIDATION_FAILED = 'register.request.fail.email.email.message';
    private const EMAIL_MIN_VALIDATION_FAILED = 'register.request.fail.email.min.message';
    private const EMAIL_MAX_VALIDATION_FAILED = 'register.request.fail.email.max.message';

    private const PASSWORD_REQUIRED_VALIDATION_FAILED = 'register.request.fail.password.required.message';
    private const PASSWORD_STRING_VALIDATION_FAILED = 'register.request.fail.password.string.message';
    private const PASSWORD_CONFIRMED_VALIDATION_FAILED = 'register.request.fail.password.confirmed.message';
    private const PASSWORD_MIN_VALIDATION_FAILED = 'register.request.fail.password.min.message';
    private const PASSWORD_MAX_VALIDATION_FAILED = 'register.request.fail.password.max.message';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email'), 'min:3', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name' => [
                'required' => __(self::FIRST_NAME_REQUIRED_VALIDATION_FAILED),
                'string' => __(self::FIRST_NAME_STRING_VALIDATION_FAILED),
                'min' => __(self::FIRST_NAME_MIN_VALIDATION_FAILED),
                'max' => __(self::FIRST_NAME_MAX_VALIDATION_FAILED),
            ],
            'last_name' => [
                'required' => __(self::LAST_NAME_REQUIRED_VALIDATION_FAILED),
                'string' => __(self::LAST_NAME_STRING_VALIDATION_FAILED),
                'min' => __(self::LAST_NAME_MIN_VALIDATION_FAILED),
                'max' => __(self::LAST_NAME_MAX_VALIDATION_FAILED),
            ],
            'email' => [
                'required' => __(self::EMAIL_REQUIRED_VALIDATION_FAILED),
                'email' => __(self::EMAIL_EMAIL_VALIDATION_FAILED),
                'unique' => __(self::EMAIL_UNIQUE_VALIDATION_FAILED),
                'min' => __(self::EMAIL_MIN_VALIDATION_FAILED),
                'max' => __(self::EMAIL_MAX_VALIDATION_FAILED),
            ],
            'password' => [
                'required' => __(self::PASSWORD_REQUIRED_VALIDATION_FAILED),
                'string' => __(self::PASSWORD_STRING_VALIDATION_FAILED),
                'confirmed' => __(self::PASSWORD_CONFIRMED_VALIDATION_FAILED),
                'min' => __(self::PASSWORD_MIN_VALIDATION_FAILED),
                'max' => __(self::PASSWORD_MAX_VALIDATION_FAILED),
            ],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = $this->failResponse(
            ResponseStatus::VALIDATION_FAILED,
            ResponseCode::VALIDATION_FAILED_CODE,
            __(self::VALIDATION_FAILED_MESSAGE),
            $validator->errors()
        );

        throw new HttpResponseException($response);
    }
}
