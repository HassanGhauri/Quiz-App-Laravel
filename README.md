# Crescent Quizzes Backend

This Laravel 11 application provides the REST API for Crescent Quizzes. It manages users, quizzes, multiple-choice questions, and quiz results for the Vue frontend. API routes are grouped under `/api/cqs`.

## Requirements

- PHP `8.2` or later
- Composer
- SQLite (default) or another database supported by Laravel

## Install

Run these commands from the `quiz-app` directory:

```powershell
composer install
if (-not (Test-Path .env)) {
    Copy-Item .env.example .env
}
```

The example configuration uses SQLite. Create the database file if it does not exist:

```powershell
if (-not (Test-Path database/database.sqlite)) {
    New-Item -ItemType File database/database.sqlite | Out-Null
}
```

On a fresh install, generate the Laravel application key. Do not regenerate an existing key. Then run all database migrations:

```powershell
php artisan key:generate
php artisan migrate
```

The migrations create the application tables and a guest user with ID `0`, which allows guest quiz results to reference a real user record.

### Use MySQL Instead

Create a database in MySQL, then update the `DB_*` values in `.env` with its connection details before migrating. For example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crescent_quizzes
DB_USERNAME=root
DB_PASSWORD=
```

## Run the API

Start the backend development server:

```powershell
php artisan serve
```

The API is available at `http://localhost:8000/api/cqs`. Start the Vue frontend in a separate terminal; its API client is configured to use this address.

## Useful Commands

```powershell
php artisan migrate:status
php artisan migrate
php artisan route:list --path=api/cqs
php artisan test
```

To apply new migrations to an existing database, run `php artisan migrate` again.
