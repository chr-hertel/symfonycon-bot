SymfonyCon Telegram Chatbot
===========================

Simple Telegram Chatbot for SymfonyCon 2019 in Amsterdam

Requirements
------------

- PHP 7.3
- Doctrine compatible database engine
- [Symfony CLI](https://symfony.com/doc/master/cloud/getting-started#installing-the-cli-tool) (or sth similar)
- [Ngrok](https://ngrok.com/download) (or sth similar)
- [Telegram Bot Token](https://core.telegram.org/bots#6-botfather)

Setup
-----

To set up this demo we need to create a telegram bot and connect our local environment to it.

```bash
$ git@github.com:chr-hertel/symfonycon-bot.git
$ cd symfonycon-bot
$ composer install
$ symfony serve -d
$ ngrok http https://localhost:8000
```

Create `.env.local` and configure
- `DATABASE_URL` - see `.env` for examples
- `TELEGRAM_TOKEN` - token provided by BotFather (eg. `1234567890:ABCD7890efgh1234IJKL5678mnop11223-3`)
- `WEBHOOK_BASE_URL` - ngrok base url (eg. `https://abcd5678.ngrok.io`)

```bash
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
$ bin/console doctrine:fixtures:load
$ bin/console app:webhook:register
```
