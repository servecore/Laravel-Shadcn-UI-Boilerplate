<?php

namespace App\Console\Commands\Shadcn;

use Illuminate\Console\Command as BaseCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

use function Laravel\Prompts\multiselect;

/**
 * Base command for Shadcn UI component management.
 *
 * @template T of array{name: string, path: string, view: string}
 */
abstract class Command extends BaseCommand implements PromptsForMissingInput
{
    /**
     * The path to the components' class directory.
     *
     * @var string
     */
    protected const CLASS_PATH = 'app/View/Components';

    /**
     * The path to the views' directory.
     *
     * @var string
     */
    protected const VIEW_PATH = 'resources/views/components';

    /**
     * The path to the JS components directory.
     *
     * @var string
     */
    protected const JS_PATH = 'resources/js/components';

    /**
     * List of all possible Component folders.
     *
     * @var Collection<string, string>
     */
    protected Collection $directories;

    /**
     * The filesystem instance.
     */
    protected Filesystem $fs;

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->fs = new Filesystem;
        $this->directories = $this->directories();
    }

    /**
     * Get the console command arguments.
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the Component already exists'],
        ];
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        $options = $this->directories
            ->mapWithKeys(fn (array $component, string $key) => [$key => $component['name']])
            ->prepend('All', '*');

        $question = $this instanceof AddComponentCommand
            ? 'Which components would you like to add?'
            : 'Which components would you like to remove?';

        return [
            'components' => fn () => multiselect(
                label   : $question,
                options : $options,
                required: true
            ),
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, T>
     */
    protected function components(): array
    {
        return $this->all()
            ? $this->directories->toArray()
            : $this->directories
                ->filter(fn (array $component, int $key) => in_array(strtolower($key), array_map('strtolower', $this->argument('components'))) ||
                    in_array(strtolower($component['name']), array_map('strtolower', $this->argument('components')))
                )
                ->toArray();
    }

    /**
     * Determine if the "All" option was selected.
     */
    private function all(): bool
    {
        return count(array_intersect(array_map('strtolower', $this->argument('components')), ['all', '*'])) > 0;
    }

    /**
     * Determine if the Component exists in the project.
     *
     * @param  array{name: string, path: string, view: string}  $component
     */
    protected function componentExists(array $component): bool
    {
        return $this->fs->exists(base_path(self::CLASS_PATH."/{$component['name']}"));
    }

    /**
     * Determine if the Component does not exist in the project.
     *
     * @param  array{name: string, path: string, view: string}  $component
     */
    protected function componentDoesNotExist(array $component): bool
    {
        return ! $this->componentExists($component);
    }

    /**
     * Get all component directories.
     *
     * @return Collection<int, T>
     */
    /**
     * The path to the stubs directory.
     *
     * @var string
     */
    protected const STUBS_PATH = 'resources/shadcn-stubs/classes';

    /**
     * Get all component directories.
     *
     * @return Collection<int, T>
     */
    private function directories(): Collection
    {
        $classPath = base_path(self::STUBS_PATH);

        if (! $this->fs->exists($classPath)) {
            return collect();
        }

        return (new Collection($this->fs->directories($classPath)))
            ->reject(fn (string $path) => Str::contains($path, 'Compiler'))
            ->map(function (string $path) {
                $name = basename($path);
                $view = Str::of($name)
                    ->ucsplit()
                    ->map(fn (string $word) => Str::lower($word))
                    ->join('-');

                return [
                    'name' => $name,
                    'path' => $path,
                    'view' => $view,
                ];
            });
    }
}
