<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| The framework finds what lives in src/
|--------------------------------------------------------------------------
|
| The skeleton ships no src/ code, so these tests drive fixture classes kept
| under tests/Fixtures/. For each test, the src/ fixtures are copied under the
| root namespace composer.json maps to src/ (a placeholder in the skeleton,
| the app's own root after a merge) and the copy joins src/ in the Composer
| class loader; tests/Fixtures/app/ joins app/ for App\. The resolvers see
| the fixtures exactly as they would see classes under src/ and app/.
|
*/

$base = dirname(__DIR__, 2);
$composer = json_decode((string) file_get_contents($base.'/composer.json'), true);
$root = (string) array_search('src/', $composer['autoload']['psr-4'], true);
$loader = ClassLoader::getRegisteredLoaders()[$base.'/vendor'];
$fixtures = new class
{
    public string $source = '';

    /** @var array<string, array<int, string>> */
    public array $prefixes = [];
};

beforeEach(function () use ($root, $loader, $fixtures): void {
    $files = new Filesystem;
    $fixtures->source = sys_get_temp_dir().'/src-wiring-'.bin2hex(random_bytes(8));
    $fixtures->prefixes = $loader->getPrefixesPsr4();

    foreach ($files->allFiles(base_path('tests/Fixtures/src')) as $file) {
        $files->ensureDirectoryExists($fixtures->source.'/'.$file->getRelativePath());
        $files->put(
            $fixtures->source.'/'.$file->getRelativePathname(),
            str_replace('Lines\Skeleton\\', $root, $file->getContents()),
        );
    }

    $loader->addPsr4($root, $fixtures->source);
    $loader->addPsr4('App\\', base_path('tests/Fixtures/app'));
});

afterEach(function () use ($root, $loader, $fixtures): void {
    foreach ([$root, 'App\\'] as $prefix) {
        $loader->setPsr4($prefix, $fixtures->prefixes[$prefix]);
    }

    (new Filesystem)->deleteDirectory($fixtures->source);
});

it('resolves a context model\'s factory from database/factories/<Context>/', function () use ($root): void {
    expect(Factory::resolveFactoryName("{$root}Core\Ordering\Domain\Models\Order"))
        ->toBe('Database\Factories\Ordering\OrderFactory');
});

it('finds a context model\'s policy in app/Policies/<Context>/', function () use ($root): void {
    expect(Gate::getPolicyFor("{$root}Core\Ordering\Domain\Models\Order"))
        ->toBeInstanceOf('App\Policies\Ordering\OrderPolicy');
});

it('discovers a listener in a context\'s Application/Listeners for the event it handles', function () use ($root, $fixtures): void {
    // The app's own discovery paths, with the fixture copy standing in for src/.
    $discovery = new ReflectionProperty(EventServiceProvider::class, 'eventDiscoveryPaths');
    $paths = [...$discovery->getValue() ?? []];

    EventServiceProvider::setEventDiscoveryPaths(array_map(
        fn (string $path): string => str_replace(base_path('src'), $fixtures->source, $path),
        $paths,
    ));

    try {
        $events = (new EventServiceProvider(app()))->discoverEvents();
    } finally {
        EventServiceProvider::setEventDiscoveryPaths($paths);
    }

    expect($events["{$root}Core\Ordering\Domain\Events\OrderPlaced"] ?? [])
        ->toContain("{$root}Core\Ordering\Application\Listeners\SendReceiptListener@handle");
});

it('leaves a model outside src/ to Laravel\'s default factory and policy guess', function (): void {
    expect(Factory::resolveFactoryName('App\Models\Post'))->toBe('Database\Factories\PostFactory')
        ->and(Gate::getPolicyFor('App\Models\Post'))->toBeInstanceOf('App\Policies\PostPolicy');
});
