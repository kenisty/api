<?php

namespace App\Http\Requests\User;

use App\Enum\ResponseCode;
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
        $response = $this->failResponse(
            ResponseCode::VALIDATION_FAILED,
            self::VALIDATION_FAILED_MESSAGE,
            $validator->errors()
        );

        throw new HttpResponseException($response);
    }
}
