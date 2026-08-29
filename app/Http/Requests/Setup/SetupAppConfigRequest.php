<?php

namespace App\Http\Requests\Setup;

use App\Http\Controllers\SetupWizardController;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SetupAppConfigRequest extends FormRequest
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
        return [
            'app_name' => ['required', 'string', 'max:100'],
            'app_url' => ['required', 'url', 'max:255'],
            'timezone' => ['required', 'string', 'max:50'],
            'locale' => ['required', 'string', 'max:10'],
            'debug_mode' => ['boolean'],
        ];
    }
}
