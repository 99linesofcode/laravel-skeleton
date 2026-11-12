<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;

/**
 * Laravel's gate, which finds a model under src/ its policy in
 * app/Policies/<Context>/. Every other model keeps Laravel's default guess.
 */
class SourceGate extends Gate
{
    /**
     * @param  string  $class
     * @return array<int, string>
     */
    protected function guessPolicyName($class)
    {
        $policy = $this->container->make(SourceRoot::class)
            ->policyFor($class, $this->container->make(Application::class)->getNamespace());

        return $policy === null ? parent::guessPolicyName($class) : [$policy];
    }
}
