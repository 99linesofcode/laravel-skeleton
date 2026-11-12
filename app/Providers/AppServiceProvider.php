<?php

namespace App\Providers;

use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Events\DiscoverEvents;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionMethod;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SourceRoot $source): void
    {
        $this->resolveFactories($source);
        $this->resolvePolicies($source);
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
     * other model keeps Laravel's default guess, asked of a gate without this
     * callback.
     */
    private function resolvePolicies(SourceRoot $source): void
    {
        Gate::guessPolicyNamesUsing(function (string $model) use ($source): array|string {
            return $source->policyFor($model, $this->app->getNamespace())
                ?? (new ReflectionMethod(AccessGate::class, 'guessPolicyName'))
                    ->invoke(new AccessGate($this->app, fn () => null), $model);
        });
    }
}
