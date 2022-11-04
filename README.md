# Admin Events test

A very basic admin created to test my skills.

## Requirement

* Ports 80, 443, 1080, and 15672 available
* [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)

## Get started

1. Run `docker compose build --pull --no-cache` to build fresh images
2. Run `docker compose up` (the logs will be displayed in the current shell)
3. Run `mkdir -p public/uploads/personlist && chmod o+w public/uploads/personlist` to create and setup the directory for upload, sorry...
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Credentials are `admin / p@ssword`
6. Run `docker compose exec php php bin/console messenger:consume async` to launch async prossessing
7. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Add-on

* RabbitMq UI : `http://localhost:15672`
* MailCatcher UI : `http://localhost:1080`

**Enjoy!**

## Credits

Created by Maxime Brignon
