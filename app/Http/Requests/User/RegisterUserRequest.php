<?php

namespace App\Http\Requests\User;

use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
{
    use ResponseTrait;

    private const VALIDATION_FAILED_MESSAGE = 'Registering failed.';

    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'min:3', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:255'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = $this->failResponse(
            ResponseStatus::VALIDATION_FAILED,
            ResponseCode::VALIDATION_FAILED_CODE,
            self::VALIDATION_FAILED_MESSAGE,
            $validator->errors()
        );

        throw new HttpResponseException($response);
    }
}
