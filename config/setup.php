<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Installer Branding
    |--------------------------------------------------------------------------
    |
    | Customize the appearance of the setup wizard.
    |
    */

    'install_title' => 'Application Setup',

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | Minimum PHP version and required extensions. The setup wizard will
    | check these before allowing the user to proceed.
    |
    */

    'core' => [
        'minPhpVersion' => '8.2.0',
    ],

    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'xml',
            'curl',
            'json',
            'bcmath',
            'fileinfo',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folder Permissions
    |--------------------------------------------------------------------------
    |
    | Directories that must be writable for the application to function.
    | Format: 'relative/path' => 'required_octal_permission'
    |
    */

    'permissions' => [
        'storage/framework/' => '775',
        'storage/logs/' => '775',
        'bootstrap/cache/' => '775',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Supported database drivers and their default ports.
    |
    */

    'database' => [
        'drivers' => ['sqlite', 'mysql', 'pgsql'],
        'default_ports' => [
            'mysql' => '3306',
            'pgsql' => '5432',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Account Validation Rules
    |--------------------------------------------------------------------------
    |
    | Validation rules and custom messages for the admin account form.
    |
    */

    'account' => [
        'rules' => [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        'messages' => [
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-generate APP_KEY
    |--------------------------------------------------------------------------
    |
    | When true, the setup wizard will automatically generate an APP_KEY
    | if one is not already set. Adopted from InstallerErag.
    |
    */

    'auto_generate_app_key' => true,

];
