<?php

namespace App\Http\Requests\Auth;

use App\Models\RegistrationInvite;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'lowercase',
            ],
        ];
    }

    /**
     * Configure the validator instance; reject emails that already belong to
     * a user, and avoid piling up invitations for the same address.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');

            if ($email && User::where('email', $email)->exists()) {
                $validator->errors()->add('email', 'An account already exists for this email. Please sign in instead.');
            }

            if ($email && RegistrationInvite::activeCountFor($email) > 0) {
                $validator->errors()->add('email', 'An invitation has already been sent to this email. Check your inbox.');
            }
        });
    }
}
