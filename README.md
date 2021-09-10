# CodeIgniter 4 Application Starter

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

Run `php spark migrate` to create the table

Run `php spark db:seed MarkSeeder` to populate test data (will take some time)

## Run

Start the server by `php spark serve`

Go to server url (default: http://localhost:8080/) to see the dashboard

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
