# AMBULAN-API
## Table of contents
- [AMBULAN-API](#ambulan-api)
  - [Table of contents](#table-of-contents)
  - [General info](#general-info)
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

## Prerequisite

* PHP
* Composer

<br/>
<br/>

	
### Technologies
Project is created with:
* laravel framework version: ^8.75
* php version: ^7.3|^8.0

<br/>
<br/>

	
### Setup
To run this project, install it locally using npm:

1. You have to run composer install
```
$ composer install
```

<br/>
<br/>


2. Setup env file

- copy env file from .env.example
<br>
<br>

For windows:

```
$ copy .env.example .env
```
Or for linux:

```
$ cp .env.example .env
```
<br>

- generate env key
```
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
```
If you want to seed the database when you migrate type command below

```
$ php artisan migrate --seed
```

<br/>
<br/>
<br/>
<br/>
<br/>


## How To Use

### Run App
To run this app make sure that you have setup the api key in .env and use it later when make connection to the API
<br>

* Run App
  
To run laravel app type in console
```
$ php artisan serve
```

if you dont change the url in .env the default link will be in http://localhost:8000/

<br>
<br>

### How To Use The API
* Auththentication API
<br>
Note that there are 3 end-point (login, register, and logout).

<br>
<br>
Register API
<br>
<br>
End-point:

```
http://localhost:8000/register
```

or any url that you have example: 
```
http://(YOUR URI)/register
```

<br>
Method: POST
<br>
<br>
<br>

Header:
```
api_key: (api key from file .env) # without brackets
```

Json-required:
```
{
  "name": "name of user",
  "phone_number": "phone number",
  "password": "user password",
  "user_role": "role of user",
  "vehicle_name": "name of vehicle",
  "registration_number": "registration number"
}
```
NB: There are just 2 value available for "user_role" (customer and driver) 
<br>
<br>
<br>
<br>
Expected Response when success:
```
{
  "status": "success",
  "message": "Register Successfully",
  "error": null,
  "content": {
    "status_code": 201,
    "access_token": "access token that you have save for auth",
    "token_type": "Bearer",
    "user_id": id of the user,
    "user_name": "user name",
    "user_role": "user role"
  }
}
```

<br>
<br>
Login API
<br>
<br>
End-point:

```
http://localhost:8000/login
```
or any url that you have example: 
```
http://(your uri)/login
```
<br>
Method: GET
<br>
<br>
<br>

Header: 
```
api_key = (api key from file .env) # without brackets
```

Json-required:
```
{
  "phone_number": "user phone number", 
  "password": "user password" 
}
```
<br>
<br>

Expected response when success:
```
{
  "status": "success",
  "message": "Login Successfully",
  "error": null,
  "content": {
    "status_code": 200,
    "access_token": "access token that you have save for auth",
    "token_type": "Bearer",
    "user_id": id of the user,
    "user_name": "user name",
    "user_role": "user role"
  }
}

```

<br>
<br>
Logout API
<br>
<br>

End-point: 
```
http://localhost:8000/logout
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/logout
```

<br>
Method: POST
<br>
<br>
<br>

Header:

    api_key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets

Json-required: No JSON required
<br>
<br>
Expected Response when success:
```
{
  "status": "success",
  "message": "Logout Successfully",
  "error": null,
  "content": null
}
```