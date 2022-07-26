# Domain Driven Laravel - Starter

Deze repository bevat een Laravel applicatie geconfigureerd volgens Domain Driven Design principes. Compleet met automations op basis van Github Actions om code automatisch te testen met behulp van PHPUnit.

## Local development

Development vindt plaats in een Docker omgeving welke je met een simpel commando kunt optuigen. We maken daarbij gebruik van een custom Laravel Sail configuratie. Voor meer informatie over de werking daarvan verwijs ik je naar de Laravel documentatie.

Het is belangrijk om te vermelden dat Laravel/Sail is geconfigureerd voor gebruik in een monorepo setup. Het verwacht dat je een project opzet met daarin twee folders: `/api` (waar de code uit deze repository leeft) en `/nuxt` (waar de code uit `nuxt-skeleton` dan komt te staan). Mocht je afwijken van die configuratie dan zul je e.e.a. aan moeten passen in de `docker-compose.yml` en bestanden onder `/docker`.

## Tech stack & Tooling

* [Laravel 9.x](https://laravel.com/docs) - PHP framework for web artisans
* [Laravel GraphQL](https://github.com/rebing/graphql-laravel) - Laravel wrapper for Facebook's GraphQL
* [Laravel Sail](https://laravel.com/docs/sail) - A command-line interface for interacting with your Docker development environment
* [PHPUnit](https://phpunit.de) - A programmer-oriented testing framework for PHP

Bovenstaande tools zijn weer gebouwd op onderstaande. Het belangrijkste is dat je weet hoe bovenstaande te gebruiken maar soms heb je meer info nodig omdat het op een lager niveau nog niet goed is geconfigureerd.

* [GraphQL](https://graphql.org) - A query language for your API
* [Apollo GraphQL](https://www.apollographql.com) - The leading open-source GraphQL implementation
* [Docker](https://www.docker.com) - Containerized development environments

Hieronder vind je tooling die gebruikt wordt om je development ervaring te verbeteren. Linters die je code fixen, bundelers die de boel plat slaan en moderne TS/JS omzetten in vanilla JS, etc.

* [ESLint](https://eslint.org) - Find and fix problems in your JavaScript code
* [Stylelint](https://stylelint.io) - Find and fix problems in your CSS code
* [Github Actions](https://github.com/features/actions) - Automate your workflow from idea to production
