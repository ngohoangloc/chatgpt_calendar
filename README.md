# Chat GPT With Calendar

## Quick Start

1. Clone the repository
2. Add your OpenAI API key to `settings.php` (see `settings.sample.php`)
3. Start a server in `public/`

```console
$ php -S localhost:8080 -t public
```

4. Go to http://localhost:8080

## Docker

```console
$ sudo docker build -t chatwtf .
$ sudo docker run -p 8080:80 chatwtf
```

Note: If you get `caught SIGWINCH, shutting down gracefully`, add the `-d` flag to run it in the background.

## Database

The chatbot uses PHP sessions to store the conversations by default. You can also use an SQL database. There is a SQLite dump and a MySQL dump in the `db` folder. You can install the SQLite version by running the `install_sqlite.php` script.

Database config has to be put into `settings.php` (see `settings.sample.php`). You need to also change `storage_type` to `sql` in the settings in order to use a database.

## API key

You will need an API key from OpenAI to use the code. The API key must be added to the `settings.sample.php` file, which you will need to rename to `settings.php`.
