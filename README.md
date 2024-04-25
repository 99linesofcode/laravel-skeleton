# Domain Driven Laravel - Starter

Deze repository bevat een Laravel applicatie geconfigureerd volgens Domain Driven Design principes. Compleet met automations op basis van Github Actions om code automatisch te testen met behulp van PHPUnit en deployen met behulp van [Kamal](https://github.com/basecamp/kamal).

## Deployment

Deployment gebeurt automatisch zodra de code in een pull request wordt gemerged naar `main`. Hou er rekening mee dat Kamal standaard is geconfigureerd om applicaties te deployen naar een server waar al een Traefik reverse proxy draait. Wil je wel een Traefik proxy dan zal je `traefik.enable` op `true` moeten zetten en mogelijk iets moeten met de standaard netwerk instellingen voor alle andere services.

Belangrijk om te vermelden is dat Kamal alleen environment variabelen uit de `.env` kan lezen als deze explicitiet mee worden gegeven in de `deploy.yml`. Kamal genereerd namelijk zijn eigen `.env` bestanden. Zie de `deploy.yml` voor een voorbeeld en kijk vooral ook even naar de documentatie op <https://kamal-deploy.org/docs/configuration/environment-variables/>.

Om te kunnen deployen dienen een aantal repository secrets toegevoegd te worden:

### `LARAVEL_ENV_ENCRYPTION_KEY`

Het wachtwoord waarmee Laravel's `.env` is versleuteld. Zie <https://laravel.com/docs/configuration#encrypting-environment-files> voor meer info.

### `SSH_PRIVATE_KEY`

Kamal maakt gebruik van SSH om in te kunnen loggen op de server. Genereer hiervoor een set SSH keys en zorg dat SSH toegang m.b.v. deze public key tot de server is toegestaan.

## SSL

Traefik is geconfigureerd voor TLS passthrough. Dit houdt in dat Traefik niet zelf het SSL certificaat gaat proberen te maken of iets doet met de TLS verbinding maar deze direct doorstuurt naar de service (docker container) die luistert naar de betreffende route. Hierdoor blijft de verbinding end-to-end encrypted in tegenstelling tot de gebruikelijke opzet waarbij de encryptie stopt bij de reverse proxy (TLS termination). Dit is niet alleen veiliger maar ook flexibeler omdat het ons in staat stelt om de service uiteindelijk op een andere VPS of cloud container te draaien zonder dat er aanpassingen nodig zijn om de communicatie tussen proxy en container veilig te stellen.

De webapplicatie zelf draait in een FrankenPHP container welke gebruik maakt van de Caddy webserver. Caddy is impliciet geconfigureerd om automatisch SSL certificaten te genereren en verlengen. De `APP_URL` wordt gebruikt om te bepalen voor welk (sub)domein een certificaat moet worden aangevraagd.

Wij maken gebruik van de Cloudflare DNS provider. Hiervoor is het noodzakelijk om een `A` record of `CNAME` record aan te maken met de waarde die overeenkomt met de `APP_URL`. Zo verifieert Caddy dat wij eigenaar zijn van de gebruikte domeinnaam.
