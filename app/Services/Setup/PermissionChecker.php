<?php

namespace App\Services\Setup;

/**
 * Checks whether server folder permissions meet the application's requirements.
 *
 * Adopted from InstallerErag's PermissionsChecker with enhanced comparison logic.
 */
class PermissionChecker
{
    /**
     * Check folder permissions against required values.
     *
     * @param  array<string, string>  $folders  Map of folder path => required octal permission
     * @return array{permissions: array<int, array{folder: string, required: string, current: string, is_set: bool}>, errors: bool}
     */
    public function check(array $folders): array
    {
        $results = [
            'permissions' => [],
            'errors' => false,
        ];

        foreach ($folders as $folder => $requiredPermission) {
            $currentPermission = $this->getPermission($folder);
            $isSet = $this->comparePermissions($currentPermission, $requiredPermission);

            $results['permissions'][] = [
                'folder' => $folder,
                'required' => $requiredPermission,
                'current' => $currentPermission,
                'is_set' => $isSet,
            ];

            if (! $isSet) {
                $results['errors'] = true;
            }
        }

        return $results;
    }

    /**
     * Get the octal permission string for a folder.
     */
    private function getPermission(string $folder): string
    {
        $path = base_path($folder);

        if (! file_exists($path)) {
            return '0000';
        }

        return substr(sprintf('%o', fileperms($path)), -4);
    }

    /**
     * Compare current permission with required permission.
     *
     * Checks if all required permission bits are set.
     */
    private function comparePermissions(string $current, string $required): bool
    {
        $currentInt = octdec($current);
        $requiredInt = octdec($required);

        return ($currentInt & $requiredInt) === $requiredInt;
    }

    /**
     * Get all permission results formatted for the setup wizard view.
     *
     * @return array<int, array{label: string, passed: bool, message: string, folder: string, required: string, current: string}>
     */
    public function run(): array
    {
        $config = config('setup.permissions', []);
        $results = $this->check($config);

        return collect($results['permissions'])->map(function (array $item) {
            $message = "{$item['folder']} (required: {$item['required']}, current: {$item['current']})";

            return [
                'label' => "Permission: {$item['folder']}",
                'passed' => $item['is_set'],
                'message' => $message,
                'folder' => $item['folder'],
                'required' => $item['required'],
                'current' => $item['current'],
            ];
        })->toArray();
    }
}
