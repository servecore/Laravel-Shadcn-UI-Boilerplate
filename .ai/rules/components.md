---
paths:
  - 'app/View/Components/**'
  - 'app/Providers/ShadcnServiceProvider.php'
  - 'resources/shadcn-stubs/**'
  - 'bootstrap/cache/components.php'
---

# Shadcn Components

## Subfolder layout is canonical
Every component family lives in its own subfolder with a class named after it:
`app/View/Components/Button/Button.php`, `Card/Card.php`, `Accordion/Accordion.php`. The alias map in `bootstrap/cache/components.php` proves the convention: `button => App\View\Components\Button\Button`. Do NOT create flat root classes like `app/View/Components/Button.php` — they collide with the subfolder namespace.

## Component alias manifest
`ShadcnServiceProvider` registers Blade aliases from a cached manifest
(`bootstrap/cache/components.php`, gitignored):

- Local env: manifest ignored, aliases rebuilt from disk every request.
- Other envs: runtime loads the file if it exists; rebuild with `php artisan shadcn:cache` after adding/removing components (writeCache + clearCache are static helpers used by the console command).
- `buildComponentAliases()` skips `compile-as-child` (registered explicitly) and files whose class cannot be loaded; aliases are `Str::kebab(filename)` and sorted with `ksort()` so output is deterministic.

## Stub sync is mandatory
`resources/shadcn-stubs/ShadcnServiceProvider.php` is the publishable template.
`php artisan shadcn:repair` (vendor:publish --force) overwrites
`app/Providers/ShadcnServiceProvider.php` FROM the stub — any optimization made
to the app provider but not mirrored in the stub is silently reverted on repair.
Keep both files identical (this burned us once: manifest caching was added to the
provider but not the stub).

## New components
Add the new class under its own subfolder; aliases auto-register (local) or need
`php artisan shadcn:cache` (other envs). Never add a separate `Blade::component`
call — the scanner handles aliases; only `compile-as-child` is registered explicitly.