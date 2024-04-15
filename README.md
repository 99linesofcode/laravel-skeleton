# Domain Driven Laravel - Starter

Deze repository bevat een Laravel applicatie geconfigureerd volgens Domain Driven Design principes. Compleet met automations op basis van Github Actions om code automatisch te testen met behulp van PHPUnit en deployen met behulp van [Kamal](https://github.com/basecamp/kamal).

# Deployment

Deployment gebeurt automatisch zodra de code in een pull request wordt gemerged naar `main`. Hiervoor dienen wel een aantal repository secrets toegevoegd te worden, namelijk:

* `CONTAINER_REGISTRY_PASSWORD`
Dit is het wachtwoord van de ingestelde container registry. Kamal logt in op https://ghcr.io met `99linesofcode` en dit wachtwoord.

* `LARAVEL_ENV_ENCRYPTION_KEY`
Het wachtwoord waarmee Laravel's `.env` is versleuteld. Zie https://laravel.com/docs/configuration#encrypting-environment-files.

* `SSH_PRIVATE_KEY`
Kamal maakt gebruik van SSH om in te kunnen loggen op de server. Genereer hiervoor een set SSH keys en zorg dat SSH toegang m.b.v. deze public key tot de server is toegestaan.
