# laravel-skeleton

A complete Laravel application that every one of my Laravel apps starts from and keeps merging. It holds laravel/laravel, merged from its `upstream` remote, plus the cross-cutting concerns I share between projects: the devshell, tooling, the committed `phpunit.xml` with its `Arch` suite, and the arch test that proves an app keeps the architecture's shape.

## How to use

### Setup

Once per machine, tell Composer where the skeleton lives. It is not on Packagist, and this entry also works while the repository is private:

```sh
composer config -g repositories.laravel-skeleton vcs git@github.com:99linesofcode/laravel-skeleton.git
```

Then make the app and join it to the skeleton's history:

1. `laravel new <app> --using=99linesofcode/laravel-skeleton`. Leave out `--pest`: the skeleton already ships Pest.
1. `cd <app> && git init && git add -A && git commit -m "chore: laravel new"`
1. `git remote add laravel-skeleton git@github.com:99linesofcode/laravel-skeleton.git`
1. `git fetch laravel-skeleton`
1. `git merge --allow-unrelated-histories laravel-skeleton/main`
1. `git submodule update --init`, which restores `devshell/`. Until this step, `.envrc`'s `use flake ./devshell` fails.

To update, run `git fetch laravel-skeleton && git merge laravel-skeleton/main`. This brings the skeleton's changes and every laravel/laravel change the skeleton has merged. Merge, never rebase or squash (git-skeleton's ADR 0001).

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
