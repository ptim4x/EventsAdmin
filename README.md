# Admin Events test

A very basic admin created to test my skills.

## Requirement

* Ports 80, 443, 1080, and 15672 available
* [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)

## Get started

2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Add-on

* RabbitMq UI : `http://localhost:15672`
* MailCatcher UI : `http://localhost:1080`

**Enjoy!**

## License

No

## Credits

Created by Maxime Brignon
