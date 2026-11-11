<?php

declare(strict_types=1);

namespace App\Providers;

use Composer\Autoload\ClassLoader;
use Illuminate\Database\Eloquent\Factories\Factory;
use RuntimeException;

/**
 * The src/ root as the framework's resolvers see it: the namespace composer.json
 * maps to src/, and the classes under it that follow the shape. Each method
 * answers for classes under the root and returns null for every other class,
 * which the caller leaves to Laravel's default guess.
 */
final readonly class SourceRoot
{
    public function __construct(public string $namespace) {}

    /**
     * Reads the root namespace from the PSR-4 mapping of src/ in composer.json.
     */
    public static function fromComposer(string $basePath): self
    {
        $composer = json_decode((string) file_get_contents($basePath.'/composer.json'), true);
        $namespace = array_search('src/', $composer['autoload']['psr-4'] ?? [], true);

        if (! is_string($namespace)) {
            throw new RuntimeException('composer.json maps no namespace to src/.');
        }

        return new self($namespace);
    }

    /**
     * The class a file under src/ declares, through the PSR-4 directories the
     * Composer class loader holds for the root namespace.
     */
    public function classForFile(string $path): ?string
    {
        $path = realpath($path);

        foreach (ClassLoader::getRegisteredLoaders() as $loader) {
            foreach ($loader->getPrefixesPsr4()[$this->namespace] ?? [] as $directory) {
                $directory = realpath($directory);

                if ($path !== false && $directory !== false && str_starts_with($path, $directory.DIRECTORY_SEPARATOR)) {
                    $relative = substr($path, strlen($directory) + 1, -strlen('.php'));

                    return $this->namespace.str_replace(DIRECTORY_SEPARATOR, '\\', $relative);
                }
            }
        }

        return null;
    }

    /**
     * Database\Factories\<Context>\<Model>Factory for <root>\Core\<Context>\Domain\Models\<Model>.
     */
    public function factoryFor(string $model): ?string
    {
        [$context, $name] = $this->contextModel($model) ?? [null, null];

        return $context === null ? null : Factory::$namespace."{$context}\\{$name}Factory";
    }

    /**
     * <app>\Policies\<Context>\<Model>Policy for <root>\Core\<Context>\Domain\Models\<Model>.
     */
    public function policyFor(string $model, string $appNamespace): ?string
    {
        [$context, $name] = $this->contextModel($model) ?? [null, null];

        return $context === null ? null : "{$appNamespace}Policies\\{$context}\\{$name}Policy";
    }

    /**
     * The context and the model's name, for <root>\Core\<Context>\Domain\Models\<Model>.
     *
     * @return array{string, string}|null
     */
    private function contextModel(string $class): ?array
    {
        $pattern = '/^'.preg_quote($this->namespace, '/').'Core\\\\([^\\\\]+)\\\\Domain\\\\Models\\\\(.+)$/';

        return preg_match($pattern, $class, $matches) === 1 ? [$matches[1], $matches[2]] : null;
    }
}
