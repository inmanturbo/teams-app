Please see https://github.com/inmanturbo/b2bsaas For a simplified, improved and updated version of this teams app. In The future inmanturbo/b2bsaas will likely be renamed to inmanturbo/teams-app! 


# The Source Code of TeamsApp

![Tests](https://github.com/inmanturbo/teamsapp/actions/workflows/test.yml/badge.svg)
![Styling](https://github.com/inmanturbo/teamsapp/actions/workflows/code-formatting.yml/badge.svg)
![Linting](https://github.com/inmanturbo/teamsapp/actions/workflows/phplint.yml/badge.svg)


## How to use this template

After following the installation steps below, develop you application as you would any other. Some important things to note:

- Each Tenant (Team) will have it's own database
- Migrations created with `php artisan make:migration` without additional options provided will be for the default database connection, which is the `teams` connection
- These migrations will run for new teams on the new team's database every a new team is created!
- New migrations can be run for all teams from the cli with `php artisan team-db:migrate`
- You may optionally pass an id as an argument to run the migrations for only one team database
  - `TeamDatabase` info is stored in the `landlords` database in `team_database` table
  - The `id` found there is the one to supply to the command i, e:
  
```bash
php artisan team-db:migrate 1
```

The above command find the team database with an id of `1` and run migrations for it

- All user account information (for all teams) is stored in the `landlord` database
- To create a new landlord migration you may run  `php artisan make:migration {migration_name} --path=database/migrations/landlord`
- To run these migrations: 

```bash
php artisan migrate --path=database/migrations/landlord --database=landlord
```

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

> Installing the icons is not required, but if you don't at least cache the icons with
> `php artisan icon:cache` The app will run very very slow even from the cli and when running unit tests

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

> This will create a super admin user with the following credentials:
>
> - email: `admin@admin.com`
> - password: `Pa$$w0rd!`

Optionally you may wish to seed the database with the following commands

```bash
php artisan migrate:fresh \
  --seed \
  --seeder=LandlordSeeder \
  --path=database/migrations/landlord \
  --database=landlord 
```

```bash
php artisan team-db:migrate --fresh --seed
```

```bash
php artisan install:icons
```
