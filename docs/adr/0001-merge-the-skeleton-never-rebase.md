# Repositories merge their skeleton, never rebase onto it or squash it

A repository takes its skeleton by adding a remote named after the skeleton (`git-skeleton`, never `skeleton`) and merging it: `git merge --allow-unrelated-histories <skeleton>/main` the first time, a plain `git merge <skeleton>/main` for every update. We used to rebase onto the skeleton, but a rebase rewrites the repository's own published history on every update, and a squash or a copy leaves no common ancestor, so every later update conflicts on every shared file. A merge keeps both histories, so a conflict shows only where the repository has deliberately diverged.

A skeleton built on another project's repository names that remote `upstream`, the usual name for the repository a project is built on: laravel-skeleton merges laravel/laravel from `upstream`, the same way, `--allow-unrelated-histories` once and a plain merge after that. Its own skeleton's remote keeps the skeleton's name (`git-skeleton`).
