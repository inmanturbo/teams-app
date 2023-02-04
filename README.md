# The Source Code of TeamsApp

![Tests](https://github.com/inmanturbo/teamsapp/actions/workflows/test.yml/badge.svg)
![Styling](https://github.com/inmanturbo/teamsapp/actions/workflows/code-formatting.yml/badge.svg)
![Linting](https://github.com/inmanturbo/teamsapp/actions/workflows/phplint.yml/badge.svg)

## Installation

### Install Dependencies

```bash
composer install
```

```bash
npm install && npm run dev
```

### Configure Environment

First copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Then edit database configurations to match your local setup

### Run Migrations

```bash
php artisan migrate:fresh --path=database/migrations/landlord --database=landlord
```

### Then install the icons

```bash
php artisan install:icons
```

### After that is finished you can generate an app key

```bash
php artisan key:generate
```

### Run Tests

```bash
php artisan test
```

### And finally serve your application

```bash
php artisan serve
```

### Seeding the database

Optionally you may wish to seed the database with the following commands

```bash
php artisan migrate:fresh --seed --path=database/migrations/landlord --database=landlord --seeder=LandlordSeeder
```

```bash
php artisan team-db:migrate --fresh --seed
```

```bash
php artisan install:icons
```
