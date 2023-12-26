# Simple Symfony Blog

# Requirements
Symfony 6.3.0+ <br>
Php 8.2+ <br>
Node 18.18.x <br>
pdo_mysql php extension enabled

# Installation

1. Clone the repository to your computer
2. Go to the project directory
3. Run `composer install`
4. Run `bin/console doctrine:database:create --if-not-exists` to create database
5. Run `bin/console doctrine:schema:create` to create database schema
6. Run `npm install && npm run build`

Start your local server: `symfony serve` and go to localhost:8000 or configure a web server like Apache

# Data Fixtures
Run `php bin/console doctrine:fixtures:load` to load fake data into a database

# Admin panel
1. Go to localhost:8000<b>/login</b>
2. Load data fixtures or create an admin user.
3. Log in to admin panel with the following credentials: <br>
<b>Username:</b> admin <br>
<b>Password:</b> qwerty()*
