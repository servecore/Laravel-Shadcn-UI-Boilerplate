<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Set the guard to the application default unless one was provided.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('guard_name')) {
            $this->merge([
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * The route is already guarded by the "manage-roles" permission middleware.
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name')->ignore($this->route('role')),
            ],
            'guard_name' => ['required', 'string', 'max:255'],
        ];
    }
}
