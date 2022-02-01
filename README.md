## Table of contents
- [Prerequisite](#prerequisite)
  - [Technologies](#technologies)
  - [Setup](#setup)
- [How To Use](#how-to-use)
  - [Run App](#run-app)
  - [How To Use The API](#how-to-use-the-api)

## General info
This project is to provide api for a mobile app.

<br/>
<br/>

# Prerequisite

* PHP
* Composer

<br/>
<br/>

	
## Technologies
Project is created with:
* laravel framework version: ^8.75
* php version: ^7.3|^8.0

<br/>
<br/>

	
## Setup
To run this project, install it locally using npm:

1. You have to run composer install
```
$ composer install
```

<br/>
<br/>


2. Setup env file

```
- copy env file from .env.example
for windows
$ copy .env.example .env
or linux
$ cp .env.example .env

- generate env key
$ php artisan key:generate
```

<br/>
<br/>


3. Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.

<br/>
<br/>

4. Setup new value in env for api key
![Screenshot](/screenshot/screenshot.jpg)

<br/>
<br/>


5. Run Migration
```
$ php artisan migrate

if you want to seed the database when you migrate type command below

$ php artisan migrate --seed

```

<br/>
<br/>
<br/>
<br/>
<br/>


# How To Use

## Run App
To run this app make sure that you have setup the api key in .env and use it later when make connection to the API
<br>

* Run App
```
To run laravel app type in console

$ php artisan serve

if you dont change the url in .env the default link will be in http://localhost:8000/
```

<br>
<br>

## How To Use The API
# AMBULAN-API
