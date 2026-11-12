<?php

declare(strict_types=1);

use Pest\Arch\Repositories\ObjectsRepository;

/*
|--------------------------------------------------------------------------
| Architecture
|--------------------------------------------------------------------------
|
| The check rules of the `architecture` skill over the application's two
| roots (docs/adr/0002-app-and-src-roots.md): `direction`, `package`,
| `sideways`, `suffix` and `shape`. Each test name starts with the rule it
| checks, so a failure names the rule. `public-interface` is left out: an
| application has no outside consumers.
|
| app/ (App\) is conventional Laravel: the UserInterface layer, with the
| composition root in app/Providers. src/ holds the shape's inside: Core,
| Infrastructure and Lib. Nothing here names a context or this application:
| the src/ root namespace is the one composer.json maps to src/, and the
| contexts are the folders found under src/Core/. Framework-owned files
| (migrations, routes, views, config, lang) sit outside both roots and
| outside the check. An application that departs from a rule records it in
| CODING_STANDARDS.md and edits this file.
|
*/

$base = dirname(__DIR__);
$composer = json_decode((string) file_get_contents($base.'/composer.json'), true);
$root = (string) array_search('src/', $composer['autoload']['psr-4'], true);
$root = rtrim($root, '\\');
$source = $base.'/src';
$app = 'App';
$appSource = $base.'/app';

// laravel-module-support's shared kernel and Lib, open to any code.
$support = ['Lines\\Support\\Core\\SharedKernel\\', 'Lines\\Support\\Lib\\'];

// Whether any folder or class matches a namespace, `*` matching one segment.
// Pest's arch layers fail on a `*` namespace that matches no folder, and a
// folder appears only with its first file. A namespace outside both roots
// counts as existing.
$exists = function (string $namespace) use ($root, $source, $app, $appSource): bool {
    $path = match (true) {
        $namespace === $root || str_starts_with($namespace, $root.'\\') => $source.substr($namespace, strlen($root)),
        $namespace === $app || str_starts_with($namespace, $app.'\\') => $appSource.substr($namespace, strlen($app)),
        default => null,
    };

    if ($path === null) {
        return true;
    }

    $path = str_replace('\\', '/', $path);

    return glob($path, GLOB_ONLYDIR) !== [] || glob($path.'.php') !== [];
};

// A namespace as the test names show it: relative to the src/ root namespace.
$relative = fn (string $namespace): string => str_starts_with($namespace, $root.'\\')
    ? substr($namespace, strlen($root) + 1)
    : $namespace;

$folders = fn (string $path): array => array_map(basename(...), glob($path.'/*', GLOB_ONLYDIR) ?: []);

$contexts = array_values(array_diff($folders($source.'/Core'), ['SharedKernel']));

// The composition root: the service providers.
$compositionRoot = "{$app}\\Providers";

// The model foundation and the framework surface the Laravel Environment
// declares for the core: Eloquent and what it returns, the contracts that
// count as ports, and the transaction and after-commit event idioms.
$framework = [
    'Illuminate\Database\Eloquent',
    'Illuminate\Support\Carbon',
    'Illuminate\Support\Collection',
    'collect',
    'now',
    'today',
    'Illuminate\Contracts\Cache',
    'Illuminate\Contracts\Mail',
    'Illuminate\Contracts\Queue',
    'Illuminate\Contracts\Events\ShouldDispatchAfterCommit',
    'Illuminate\Foundation\Events\Dispatchable',
    'Illuminate\Queue\SerializesModels',
    'Illuminate\Support\Facades\DB',
];

// Defines an arch test only when its target and at least one dependency exist.
$denies = function (string $rule, string $target, array $dependencies, array $ignoring = []) use ($exists, $relative): void {
    $dependencies = array_values(array_filter($dependencies, $exists));

    if ($exists($target) && $dependencies !== []) {
        arch("{$rule}: {$relative($target)} uses no ".implode(', ', array_map($relative, $dependencies)))
            ->expect($target)
            ->not->toUse($dependencies)
            ->ignoring($ignoring);
    }
};

/*
| direction: app/ → Application → Domain, adapters → the core, and downward
| to the shared kernel, Lib and the language, plus the declared model
| foundation. Nothing in src/ uses app/.
*/

$denies('direction', "{$root}\\Core\\*\\Domain", ["{$root}\\Core\\*\\Application", "{$root}\\Infrastructure"]);
$denies('direction', "{$root}\\Core\\*\\Application", ["{$root}\\Infrastructure"]);
$denies('direction', "{$root}\\Core\\SharedKernel", [
    ...array_map(fn (string $context): string => "{$root}\\Core\\{$context}", $contexts),
    "{$root}\\Infrastructure",
]);
$denies('direction', "{$root}\\Infrastructure", [$app]);
$denies('direction', "{$root}\\Lib", ["{$root}\\Core", "{$root}\\Infrastructure", $app]);
$denies('direction', $app, ["{$root}\\Infrastructure"], [$compositionRoot]);

if (glob($source.'/*') !== []) {
    arch("direction: nothing in src/ uses {$app}")
        ->expect($root)
        ->not->toUse($app);
}

if ($exists("{$root}\\Core")) {
    arch('direction: the core uses only the core, Lib, support\'s shared kernel and Lib, and the declared framework surface')
        ->expect("{$root}\\Core")
        ->toOnlyUse(["{$root}\\Lib", ...$framework])
        ->ignoring($support);
}

/*
| package: other Lines\ packages are reached only through the composition
| root and the adapters. Elsewhere a class uses no Lines\ namespace but the
| src/ root, support's shared kernel and Lib, and, from app/ only, a
| package's UserInterface. Third-party packages stay unrestricted.
*/

test('package: other Lines\ packages are used only from app/Providers and src/Infrastructure', function () use ($root, $app, $support, $compositionRoot): void {
    $offenders = [];

    // Reads uses through Pest's own repository, as the arch() tests do: a
    // use counts only when the used class exists. Pest's toUse cannot say
    // "every Lines\ namespace but these", so this test reads them itself.
    $check = function (string $namespace, array $skip, callable $allowed) use (&$offenders): void {
        foreach (ObjectsRepository::getInstance()->allByNamespace($namespace) as $object) {
            if (! str_starts_with($object->name, $namespace.'\\')) {
                continue;
            }

            foreach ($skip as $prefix) {
                if (str_starts_with($object->name, $prefix.'\\')) {
                    continue 2;
                }
            }

            foreach ($object->uses as $use) {
                if (str_starts_with($use, 'Lines\\') && ! $allowed($use)) {
                    $offenders[] = "{$object->name} uses {$use}";
                }
            }
        }
    };

    $isOpen = fn (string $use): bool => str_starts_with($use, $root.'\\')
        || array_filter($support, fn (string $prefix): bool => str_starts_with($use, $prefix)) !== [];

    $check($app, [$compositionRoot], fn (string $use): bool => $isOpen($use)
        || preg_match('/^Lines\\\\[^\\\\]+\\\\UserInterface\\\\/', $use) === 1);
    $check($root, ["{$root}\\Infrastructure"], $isOpen);

    expect(array_values(array_unique($offenders)))->toBe([]);
});

/*
| sideways: a context uses no other context's code. Every context folder on
| disk is checked against its siblings, so a new context needs no edit here.
*/

foreach ($contexts as $context) {
    $siblings = array_map(
        fn (string $sibling): string => "{$root}\\Core\\{$sibling}",
        array_values(array_diff($contexts, [$context])),
    );

    if ($siblings !== []) {
        arch("sideways: {$context} uses no sibling context")
            ->expect("{$root}\\Core\\{$context}")
            ->not->toUse($siblings);
    }
}

/*
| suffix: application and adapter roles under src/ carry their role
| folder's suffix.
*/

$suffixes = [
    "{$root}\\Core\\*\\Application\\Actions" => 'Action',
    "{$root}\\Core\\*\\Application\\Queries" => 'Query',
    "{$root}\\Core\\*\\Application\\Ports" => 'Port',
    "{$root}\\Core\\*\\Application\\Listeners" => 'Listener',
    "{$root}\\Core\\*\\Application\\DataTransferObjects" => 'Data',
    "{$root}\\Infrastructure" => 'Adapter',
];

foreach ($suffixes as $folder => $suffix) {
    if ($exists($folder)) {
        arch('suffix: '.basename(str_replace('\\', '/', $folder))." classes end in {$suffix}")
            ->expect($folder)
            ->toHaveSuffix($suffix);
    }
}

/*
| shape: under src/, layers first, contexts only inside Core, roles in
| their folders, and every file under the src/ root namespace. app/ keeps
| Laravel's folders and holds none of the shape's.
*/

$entries = fn (string $path): array => array_values(array_filter(
    is_dir($path) ? (scandir($path) ?: []) : [],
    fn (string $entry): bool => ! str_starts_with($entry, '.'),
));

test('shape: src/ holds only the shape\'s folders', function () use ($source, $entries): void {
    // Lists what under $path is a file, or a folder not in $allowed (null: any folder).
    $offShape = function (string $path, ?array $allowed) use ($entries, $source): array {
        if (! is_dir($path)) {
            return [];
        }

        return array_values(array_map(
            fn (string $entry): string => 'src/'.substr("{$path}/{$entry}", strlen($source) + 1),
            array_filter(
                $entries($path),
                fn (string $entry): bool => ! is_dir("{$path}/{$entry}")
                    || ($allowed !== null && ! in_array($entry, $allowed, true)),
            ),
        ));
    };

    $offenders = [
        ...$offShape($source, ['Core', 'Infrastructure', 'Lib']),
        ...$offShape($source.'/Infrastructure', null),
        ...$offShape($source.'/Core', null),
        ...$offShape($source.'/Core/SharedKernel', ['Events', 'ValueObjects']),
    ];

    foreach (array_diff($entries($source.'/Core'), ['SharedKernel']) as $context) {
        $offenders = [
            ...$offenders,
            ...$offShape("{$source}/Core/{$context}", ['Application', 'Domain']),
            ...$offShape("{$source}/Core/{$context}/Application", ['Actions', 'Queries', 'Listeners', 'Ports', 'DataTransferObjects']),
            ...$offShape("{$source}/Core/{$context}/Domain", ['Models', 'Events', 'ValueObjects', 'Services']),
        ];
    }

    expect($offenders)->toBe([]);
});

test('shape: app/ holds none of the shape\'s folders', function () use ($appSource, $entries): void {
    $offenders = array_values(array_map(
        fn (string $entry): string => "app/{$entry}",
        array_intersect(
            $entries($appSource),
            ['Core', 'Infrastructure', 'Lib', 'Actions', 'Queries', 'Ports', 'DataTransferObjects'],
        ),
    ));

    expect($offenders)->toBe([]);
});

test('shape: every PHP file under src/ declares a namespace under the src/ root', function () use ($base, $source, $root): void {
    $offenders = [];

    if (is_dir($source)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS));

        foreach ($files as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $declared = preg_match('/^\s*namespace\s+([^\s;{]+)/m', (string) file_get_contents($file->getPathname()), $match) === 1
                ? $match[1]
                : null;

            if ($declared !== $root && ! str_starts_with((string) $declared, $root.'\\')) {
                $offenders[] = substr($file->getPathname(), strlen($base) + 1).' declares '.($declared ?? 'no namespace');
            }
        }
    }

    expect($offenders)->toBe([]);
});
