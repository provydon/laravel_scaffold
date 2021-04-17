<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
# Laravel Scaffold

### Kick start a laravel application with basic things already setup for you so that you can focus on your business logic

### The following features have been added for you

#### Laravel jetstream

#### Laravel 8.. and can run on PHP 7.4 or PHP 8

#### Login/signup with Google

#### Beautiful admin panel for with Laravel nova setup

#### Admin roles/permissions setup for you

#### Email notifications setup for so u can can start sending emails immediately after setting ur env details

#### Already has profile edit/ 2FA auth(optional) changing password and other basic profile edits) setup for u with beautiful ui tru laravel jetstream and Laravel inertia

#### Already added fontawesome for you

#### Already added toastr for you

#### Laravel jetstream

## Inital Build Setup

```bash
# install dependencies
$ composer install

# autoload dependencies
$ composer dump-autoload

# create a .env file in the root of the project, and copy and paste the contents of .env.example into it and save it.

# Set Your Keys and APi Keys in the .env file.

# migrate and seed
$ php artisan migrate --seed

# install passport for api
$ php artisan passport:install


# start server
$ php artisan serve

# And you're good to go!
```

## After Build Setup (Insace of Database Refresh)

```bash
# After you've started the server sometime later in the future during development, if u wish to refresh the database, run
$ php artisan migrate:refresh --seed

# Then reset access token for the api
$ php artisan passport:client --personal

# And you're good to go!
```

For detailed explanation on how things work, check out [Laravel docs](https://laravel.com).
