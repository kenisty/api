<?php declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enum\ResponseCode;
use App\Http\Responses\User\UserFailedRegistrationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    private const VALIDATION_FAILED_MESSAGE = 'auth.register.failed.response.message';

    private const FIRST_NAME_REQUIRED_VALIDATION_FAILED = 'auth.register.failed.request.firstName.required';
    private const FIRST_NAME_STRING_VALIDATION_FAILED = 'auth.register.failed.request.firstName.string';
    private const FIRST_NAME_MIN_VALIDATION_FAILED = 'auth.register.failed.request.firstName.min';
    private const FIRST_NAME_MAX_VALIDATION_FAILED = 'auth.register.failed.request.firstName.max';

    private const LAST_NAME_REQUIRED_VALIDATION_FAILED = 'auth.register.failed.request.lastName.required';
    private const LAST_NAME_STRING_VALIDATION_FAILED = 'auth.register.failed.request.lastName.string';
    private const LAST_NAME_MIN_VALIDATION_FAILED = 'auth.register.failed.request.lastName.min';
    private const LAST_NAME_MAX_VALIDATION_FAILED = 'auth.register.failed.request.lastName.max';

    private const EMAIL_REQUIRED_VALIDATION_FAILED = 'auth.register.failed.request.email.required';
    private const EMAIL_UNIQUE_VALIDATION_FAILED = 'auth.register.failed.request.email.unique';
    private const EMAIL_EMAIL_VALIDATION_FAILED = 'auth.register.failed.request.email.email';
    private const EMAIL_MIN_VALIDATION_FAILED = 'auth.register.failed.request.email.min';
    private const EMAIL_MAX_VALIDATION_FAILED = 'auth.register.failed.request.email.max';

    private const PASSWORD_REQUIRED_VALIDATION_FAILED = 'auth.register.failed.request.password.required';
    private const PASSWORD_STRING_VALIDATION_FAILED = 'auth.register.failed.request.password.string';
    private const PASSWORD_CONFIRMED_VALIDATION_FAILED = 'auth.register.failed.request.password.confirmed';
    private const PASSWORD_MIN_VALIDATION_FAILED = 'auth.register.failed.request.password.min';
    private const PASSWORD_MAX_VALIDATION_FAILED = 'auth.register.failed.request.password.max';

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
                'required' => trans(self::FIRST_NAME_REQUIRED_VALIDATION_FAILED),
                'string' => trans(self::FIRST_NAME_STRING_VALIDATION_FAILED),
                'min' => trans(self::FIRST_NAME_MIN_VALIDATION_FAILED),
                'max' => trans(self::FIRST_NAME_MAX_VALIDATION_FAILED),
            ],
            'last_name' => [
                'required' => trans(self::LAST_NAME_REQUIRED_VALIDATION_FAILED),
                'string' => trans(self::LAST_NAME_STRING_VALIDATION_FAILED),
                'min' => trans(self::LAST_NAME_MIN_VALIDATION_FAILED),
                'max' => trans(self::LAST_NAME_MAX_VALIDATION_FAILED),
            ],
            'email' => [
                'required' => trans(self::EMAIL_REQUIRED_VALIDATION_FAILED),
                'email' => trans(self::EMAIL_EMAIL_VALIDATION_FAILED),
                'unique' => trans(self::EMAIL_UNIQUE_VALIDATION_FAILED),
                'min' => trans(self::EMAIL_MIN_VALIDATION_FAILED),
                'max' => trans(self::EMAIL_MAX_VALIDATION_FAILED),
            ],
            'password' => [
                'required' => trans(self::PASSWORD_REQUIRED_VALIDATION_FAILED),
                'string' => trans(self::PASSWORD_STRING_VALIDATION_FAILED),
                'confirmed' => trans(self::PASSWORD_CONFIRMED_VALIDATION_FAILED),
                'min' => trans(self::PASSWORD_MIN_VALIDATION_FAILED),
                'max' => trans(self::PASSWORD_MAX_VALIDATION_FAILED),
            ],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = (new UserFailedRegistrationResponse())
            ->setResponseCode(ResponseCode::VALIDATION_FAILED)
            ->setMessageTranslationKey(self::VALIDATION_FAILED_MESSAGE)
            ->setData($validator->errors()->toArray());

        throw new HttpResponseException($response->getResponse());
    }
}
