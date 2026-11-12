<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Events\DiscoverEvents;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use SplFileInfo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SourceRoot::class, fn (): SourceRoot => SourceRoot::fromComposer($this->app->basePath()));

        $this->discoverListeners();
        $this->resolvePolicies();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SourceRoot $source): void
    {
        $this->resolveFactories($source);
    }

    /**
     * A listener file under src/ is the class its path names under the root
     * namespace; every other file keeps Laravel's default guess. Discovery runs
     * when the event service provider boots, so this is set at registration.
     */
    private function discoverListeners(): void
    {
        DiscoverEvents::guessClassNamesUsing(function (SplFileInfo $file, string $basePath): string {
            $source = $this->app->make(SourceRoot::class);
            $class = trim(Str::replaceFirst($basePath, '', (string) $file->getRealPath()), DIRECTORY_SEPARATOR);

            return $source->classForFile($file->getPathname()) ?? ucfirst(Str::camel(str_replace(
                [DIRECTORY_SEPARATOR, ucfirst(basename($this->app->path())).'\\'],
                ['\\', $this->app->getNamespace()],
                ucfirst(Str::replaceLast('.php', '', $class)),
            )));
        });
    }

    /**
     * A model under src/ gets its factory from database/factories/<Context>/;
     * every other model keeps Laravel's default guess.
     */
    private function resolveFactories(SourceRoot $source): void
    {
        Factory::guessFactoryNamesUsing(function (string $model) use ($source): string {
            $app = $this->app->getNamespace();

            return $source->factoryFor($model) ?? Factory::$namespace.(Str::startsWith($model, $app.'Models\\')
                ? Str::after($model, $app.'Models\\')
                : Str::after($model, $app)).'Factory';
        });
    }

    /**
     * A model under src/ gets its policy from app/Policies/<Context>/; every
     * other model keeps Laravel's default guess. The framework's providers
     * register first, so this binding replaces the framework's gate.
     */
    private function resolvePolicies(): void
    {
        $this->app->singleton(Gate::class, fn (): SourceGate => new SourceGate(
            $this->app,
            fn () => call_user_func($this->app->make('auth')->userResolver()),
        ));
    }
}
