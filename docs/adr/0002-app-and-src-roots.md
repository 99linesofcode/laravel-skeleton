# An app has two roots: app/ for Laravel, src/ for the shape

An app made from the skeleton keeps `app/` as conventional Laravel and puts the `architecture` skill's shape in `src/`:

- `app/` (`App\`) is the UserInterface layer (controllers, requests, middleware, policies, commands) plus the composition root in `app/Providers/`. Stock `make:*` keeps writing here.
- `src/` holds the shape's inside: `Core/<Context>/{Application,Domain}`, `Core/SharedKernel`, `Infrastructure/<Tool>` and `Lib`. Its root namespace is the one `composer.json` maps to `src/`, a placeholder in the skeleton that each app renames to its own. Code and tests read it from `composer.json`, as `tests/ArchTest.php` does.

We rejected two other layouts:

- **The whole shape inside `app/`.** Laravel's stock folders (`Http/`, `Models/`, `Providers/`) and its `make:*` commands would sit beside the shape's layers as peers and keep generating into them, so every app would carry off-shape folders or patched generators.
- **A conventional app holding only packages.** Each context would be its own `Lines\` package, which leaves no home for the contexts that belong to one app alone.

## Users come from laravel-module-user

laravel-module-user owns the auth model that `config/auth.php` names. The core knows a user only as `UserId`, and reads user details through `UserDirectoryPort`, which laravel-module-user implements. Both, with the `AsUserId` cast, live in laravel-module-support's shared kernel, which the **package** rule leaves open. A context keeps its own data about a user in its own tables, keyed by a `user_id` cast with `AsUserId`, and its relations stay inside the context. The user interface passes the signed-in user's `UserId` into an action's data, so the core never asks who is signed in. Until laravel-module-support ships these types and laravel-module-user implements the port, the skeleton keeps Laravel's stock `App\Models\User`.

## The arch test holds both roots

`tests/ArchTest.php` checks `app/` and `src/` together:

- **direction**: `app/` may use all of `src/Core`, models included. Only `app/Providers` may use `src/Infrastructure`, and nothing in `src/` uses `App\`.
- **package**: other `Lines\` packages are reached only from `app/Providers` and `src/Infrastructure`. Any code may use laravel-module-support's `Core\SharedKernel` and `Lib`, and `app/` may use a package's `UserInterface`.
- **sideways**, **suffix** and **shape** apply under `src/`. The shape rule also keeps the shape's layer and role folders out of the top of `app/`, and requires every PHP file under `src/` to declare a namespace under the app's root, which catches a skeleton merge that brings in a file under the skeleton's placeholder namespace.
- **public-interface** stays out: an app has no outside consumers.

An app that departs from a rule records it in `CODING_STANDARDS.md` and edits the test.

## laravel/laravel's own repository files stay out

laravel/laravel ships files that run its own repository, not an app: `.github/dependabot.yml`, its `.github/workflows/`, `.styleci.yml` and Boost's `CLAUDE.md`. The skeleton deleted them and keeps its own `.github` from git-skeleton. When laravel/laravel changes one, the `upstream` merge stops on a modify/delete conflict in the skeleton: delete the file again. Apps merge the skeleton, not laravel/laravel, so they never see this conflict.
