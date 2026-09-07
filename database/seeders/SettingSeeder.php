<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'toast.position' => ['value' => 'top-right', 'group' => 'ui', 'type' => 'string', 'description' => 'Default toast notification position'],
            'theme.default' => ['value' => 'system', 'group' => 'ui', 'type' => 'string', 'description' => 'Default color theme'],
            'locale.default' => ['value' => 'en', 'group' => 'app', 'type' => 'string', 'description' => 'Default application locale'],
        ];

        foreach ($defaults as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'group' => $data['group'],
                    'type' => $data['type'],
                    'description' => $data['description'],
                    'is_public' => true,
                ]
            );
        }
    }
}
