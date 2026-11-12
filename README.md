# laravel-skeleton

A complete Laravel application that every one of my Laravel apps starts from and keeps merging. It holds laravel/laravel, merged from its `upstream` remote, plus the cross-cutting concerns I share between projects: the devshell, tooling, the committed `phpunit.xml` with its `Arch` suite, and the arch test that proves an app keeps the architecture's shape.

## How to use

### Setup

Make an app with the skill suite's `/instantiate`, choosing the `laravel-app` stack. It merges this skeleton into a new repository, renames the `Lines\Skeleton` namespace to the app's own, then runs `composer setup`, `composer lint` and `composer test`.

To update an app, run `git fetch laravel-skeleton && git merge laravel-skeleton/main`. This brings the skeleton's changes and every laravel/laravel change the skeleton has merged. Merge, never rebase or squash (`docs/adr/0001-merge-the-skeleton-never-rebase.md`).

### Development environment

I work with NixOS and most of my code/starters ship with a `devshell`. If you have access to direnv and the Nix package manager, you can be up an running with `direnv allow`.

Then run `composer setup` once. It installs the dependencies, writes `.env` and the app key, creates `database/database.sqlite`, migrates the database and builds the frontend. `composer dev` runs the server, queue worker, log tail and Vite together. `composer lint && composer test` is the check.

### Updating Laravel in the skeleton

laravel/laravel is the skeleton's `upstream` remote. Its changes arrive by a plain merge of its default branch: `git fetch upstream && git merge upstream/13.x`, moving to the next `*.x` branch when Laravel releases one.

## Contributing

Please review the [Contribution Guidelines](https://github.com/99linesofcode/.github/blob/main/.github/CONTRIBUTING.md).

## Code of conduct

In order to ensure that the community is welcoming to all, please review and abide by the [Code of Conduct](https://github.com/99linesofcode/.github?tab=coc-ov-file).

## Security vulnerabilities

Please review the [security policy](https://github.com/99linesofcode/.github?tab=security-ov-file) on how to report security vulnerabilities.

## License

This software is open source and licensed under the [MIT license](https://github.com/99linesofcode/.github?tab=MIT-1-ov-file).
