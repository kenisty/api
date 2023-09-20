<?php declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enum\ResponseCode;
use App\Http\Responses\User\UserFailedLoginResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
{
    private const VALIDATION_FAILED_MESSAGE = 'Login failed.';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = (new UserFailedLoginResponse())
            ->setResponseCode(ResponseCode::VALIDATION_FAILED)
            ->setMessageTranslationKey(self::VALIDATION_FAILED_MESSAGE)
            ->setData($validator->errors()->toArray());

        throw new HttpResponseException($response->getResponse());
    }
}
