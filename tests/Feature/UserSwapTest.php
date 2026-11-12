<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Lines\Auth\Database\Factories\UserFactory;

/*
|--------------------------------------------------------------------------
| An app's user comes from laravel-module-user
|--------------------------------------------------------------------------
|
| The skeleton signs its users in through laravel-module-user's auth model
| and ships none of the stock User files (docs/adr/0002-app-and-src-roots.md).
|
*/

uses(RefreshDatabase::class);

it('names laravel-module-user\'s auth model as the users provider\'s model', function (): void {
    expect(config('auth.providers.users.model'))->toBe('Lines\Auth\Infrastructure\Models\User');
});

it('ships no stock User model, factory or users migration', function (): void {
    expect(base_path('app/Models/User.php'))->not->toBeFile()
        ->and(database_path('factories/UserFactory.php'))->not->toBeFile()
        ->and(database_path('migrations/0001_01_01_000000_create_users_table.php'))->not->toBeFile();
});

it('signs in a user made by laravel-module-user\'s factory by its UUID', function (): void {
    $user = UserFactory::new()->create();

    $this->actingAs($user);

    expect(auth()->id())->toBe($user->getKey())
        ->and(Str::isUuid(auth()->id()))->toBeTrue();
});
