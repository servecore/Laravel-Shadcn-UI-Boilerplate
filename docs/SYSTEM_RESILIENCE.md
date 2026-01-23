# System Resilience Features 🛡️

This boilerplate comes equipped with a custom-built resilience system to ensure stability and offline capability.

## 1. Local Component Registry 📦
Unlike standard installations that rely on GitHub availability, this project maintains a **Master Copy** of all UI components locally.

- **Location:** `resources/shadcn-stubs/`
- **Purpose:** Acts as an offline backup for all Shadcn UI components.

### How it Works
The artisan commands have been modified to interact with this local registry instead of fetching from the internet.

- **Storage Structure:**
  - `classes/`: PHP Component Classes (`app/View/Components`)
  - `components/`: Blade Views (`resources/views/components`)
  - `js/`: JavaScript assets (`resources/js/components`)

## 2. Component Management Commands ⚙️

### Add Component
Restores or adds a component from the Local Registry to your active application.
```bash
php artisan shadcn:add [component-name]
# Example:
php artisan shadcn:add avatar
```

### Remove Component
Safely removes a component from your application layer. **Your Local Registry backup is NOT affected.**
```bash
php artisan shadcn:remove [component-name]
# Example:
php artisan shadcn:remove avatar
```

## 3. Auto-Repair System 🛠️
A failsafe command designed to recover from critical human errors, such as accidental deletion of system files.

### The Repair Command
```bash
php artisan shadcn:repair
```

### Capabilities
1.  **File Restoration:** Automatically detects if `ShadcnServiceProvider.php` is missing and restores it from the Local Registry.
2.  **Auto-Registration:** Intelligently scans `bootstrap/providers.php`. If the Service Provider is not registered, it auto-injects the registration code.

### When to use?
- If you accidentally deleted `app/Providers/ShadcnServiceProvider.php`.
- If you see "ShadcnServiceProvider not found" errors.
- If you want to reset critical system files to their default state.
