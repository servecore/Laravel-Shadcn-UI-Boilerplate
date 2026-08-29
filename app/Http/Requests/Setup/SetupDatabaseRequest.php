<?php

namespace App\Http\Requests\Setup;

use App\Http\Controllers\SetupWizardController;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SetupDatabaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! app(SetupWizardController::class)::isSetup();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $driver = $this->input('driver', 'sqlite');

        $base = [
            'driver' => ['required', 'string', 'in:sqlite,mysql,pgsql'],
        ];

        if ($driver === 'sqlite') {
            return $base;
        }

        return array_merge($base, [
            'host' => ['required', 'string', 'max:255'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'database' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
