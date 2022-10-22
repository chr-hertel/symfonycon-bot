SymfonyCon Telegram Chatbot
===========================

Telegram Chatbot for SymfonyCon Disneyland Paris 2022

Find it on Telegram: [@SymfonyConBot](https://t.me/SymfonyConBot)

Requirements
------------

- PHP 8.1
- Doctrine compatible database engine
- [Symfony CLI](https://symfony.com/doc/master/cloud/getting-started#installing-the-cli-tool) (or sth similar)
- [Ngrok](https://ngrok.com/download) (or sth similar)
- [Telegram Bot Token](https://core.telegram.org/bots#6-botfather)

Setting up ngrok
----------------

The Telegram bot will communicate with our application to process messages and reply to them. This requires a websocket
connection that is reachable from the outside world, i.e. the internet. This can be achieved by deploying the
application, e.g. using [Symfony Cloud](https://symfony.com/cloud/), or exposing the local environment through an
HTTPS tunnel service like [serveo](https://serveo.net/) or [ngrok](https://ngrok.com).

1. Download and install the ngrok client
1. Sign up for a private ngrok account on https://ngrok.com
1. Go to the Auth section in the dashboard and follow the instructions for setting the auth token
1. Run ngrok: `ngrok http https://localhost:8000`
    The URL `https://localhost:8000` refers to our local Symfony Server, so be careful to update the port info
    if necessary.

When you run ngrok, you will see `Forwarding` addresses like `https://abcd5678.ngrok.io`. You will need this value for
the `WEBHOOK_BASE_URL` environment variable. Alternatively you can copy `.env` as `.env.local` and set the value there.

Setting up the Telegram bot
---------------------------

You will need to set up a Telegram bot to interact with. You can do this through Telegram by sending a message
to a bot [`@BotFather`](https://core.telegram.org/bots#6-botfather) and following the instructions. Alternatively
you can use the CLI as described in the link above.

Once you finished setting up the bot you will get a long message with an auth token that looks something like:
`1234567890:ABCD7890efgh1234IJKL5678mnop11223-3`.

This token is used for the environment variable `TELEGRAM_TOKEN`.

Setting up the database
-----------------------

Set up a database using a platform supported by Doctrine ORM, e.g. MySQL, PostgreSQL or SQLite3. Set the database DSN
using the environment variable `DATABASE_URL` or by setting the value in our `.env.local`. You can find an example
for an SQLite3 DSN in the `.env` file, which should be suitable for first development steps.

Setup
-----

To set up this demo we need to create a telegram bot and connect our local environment to it (see sections above).

1. Clone the repository and go into the project root:

    ```bash
    git clone git@github.com:chr-hertel/symfonycon-bot.git
    cd symfonycon-bot
    ```

1. Install the dependencies

    ```bash
    composer install
    ```

1. Set up ngrok and start the tunnel

    ```bash
    ngrok http https://localhost:8000
    ```

1. Set up Telegram bot (only necessary on first run)

1. Set up the database and environment variables

    - `DATABASE_URL` - see `.env` for examples
    - `TELEGRAM_TOKEN` - token provided by BotFather (eg. `1234567890:ABCD7890efgh1234IJKL5678mnop11223-3`)
    - `WEBHOOK_BASE_URL` - ngrok base url (eg. `https://abcd5678.ngrok.io`)

1. Start the development server using the [Symfony CLI](https://symfony.com/doc/current/setup/symfony_server.html)

    ```bash
    symfony serve --detach
    ```

1. Set up the entities

    ```bash
    bin/console doctrine:database:create
    bin/console doctrine:schema:create
    bin/console doctrine:fixtures:load # Schedule of 2019
    ```

1. Load schedule of 2022 (optional)

   ```bash
   bin/console app:schedule:crawl
   ```
   
1. Set up the webhook & menu (only necessary once)

    ```bash
    bin/console app:webhook:register
    bin/console app:command:register
    ```

1. Set up search functionality 

    To use the search in your local development environment, setup an
    [Algolia Account](https://www.algolia.com/) and configure following keys
    in your `.env.local`:

    ```dotenv
    ALGOLIA_APP_ID=
    ALGOLIA_API_KEY=
    ```

    To set up the search index, run:

    ```bash
    bin/console search:settings:push
    bin/console search:import
    ```

Testing
-------

**Relevant tools**

* [PHP CS Fixer](https://cs.symfony.com/)

   ```
   php vendor/bin/php-cs-fixer fix
   ```

* [PHPStan](https://phpstan.org/)

   ```
   php vendor/bin/phpstan analyse
   ```

* [PHPUnit](https://phpunit.de/)

   ```
   # without coverage
   php bin/phpunit
  
   # with coverage, but without functional tests
   XDEBUG_MODE=coverage php bin/phpunit --coverage-html=public/phpunit --exclude=functional
   ```

* [Infection](https://infection.github.io/) (not executed in pipeline)

   ```
   php vendor/bin/infection
   ```

Pipeline
--------

Pipeline is executed with GitHub Actions on Pull Requests.

You can simulate locally with:

```bash
bin/check
```

Deployment
----------

Deployment is executed with GitHub Action on push on `main` branch using [Deployer](https://deployer.org/).
