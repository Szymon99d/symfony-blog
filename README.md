# Simple Symfony Blog

# Requirements
Symfony 5.3.9+ <br>
Php 8.0.9+ <br>
pdo_mysql php extension enabled

# Installation

1. Clone the repository to your computer
2. Go to the project directory
3. Run `composer install`
4. Run `php bin/console doctrine:database:create` to create database
5. Run `php bin/console doctrine:migrations:diff` to create migration file
6. Run `php bin/console doctrine:migrations:migrate` to execute migration

Start your local server: `symfony serve` and go to localhost:8000 or configure a web server like Apache

# Data Fixtures
Run `php bin/console doctrine:fixtures:load` to load fake data into a database <br>
or <br>
import your own set of data

# Admin panel
1. Go to your_domain<b>/login</b>
2. Log in to admin panel with the following credentials: <br>
<b>Username:</b> admin <br>
<b>Password:</b> qwerty()*

