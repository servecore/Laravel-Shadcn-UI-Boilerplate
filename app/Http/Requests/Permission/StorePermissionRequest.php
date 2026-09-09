<?php

namespace App\Http\Requests\Permission;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
     * The route is already guarded by the "manage-permissions" permission middleware.
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
            'name' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:permissions,name'],
            'guard_name' => ['required', 'string', 'max:255'],
        ];
    }
}
