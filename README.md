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
<h3> Register API </h3>
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
x-api-key: (api key from file .env) # without brackets
```

Json-required:
```
// for driver user
{
  "name": "name of user",
  "phone_number": "phone number",
  "password": "user password",
  "user_role": "user password",
  "vehicle_name": "name of vehicle",
  "registration_number": "registration number"
}
```

```
// for customer user
{
  "name": "name of user",
  "phone_number": "phone number",
  "password": "user password",
  "user_role": "role of user",
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
<h3> Login API </h3>
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
x-api-key = (api key from file .env) # without brackets
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
<h3> Logout API </h3>
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

    x-api-key = (api key from file .env) # without brackets
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

<br>
<br>
<br>
<br>
<br>
<br>

* Order API

<br>
<h3> Make Order API </h3>
<br>
<br>

End-point: 
```
http://localhost:8000/store-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/store-order
```

<br>
Method: POST
<br>
<br>
<br>

Header:

    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets

Json-required:
```
{
  "pick_up_detail": "pick up detail",
  "pick_up_latitude": "pick up latitude",
  "pick_up_longitude": "pick up longitude",
  "drop_off_detail": "drop off latitude",
  "drop_off_latitude": "drop off latitude",
  "drop_off_longitude": "drop off longitude",
}
```

<br>
<br>
Expected Response when success:

```
{
  "status": "success",
  "message": "Created Successfully",
  "error": null,
  "content": {
    "status_code": 201,
    "order_id": "id of order",
    "status": "searching"
  }
}
```

<br>
<h3> Check Order API </h3>
<br>
<br>

End-point: 
```
http://localhost:8000/check-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/check-order
```

<br>
Method: POST
<br>
<br>
<br>

Header:

    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets

Json-required:

```
// id of order
{
    "order_id": "3"
}
```

<br>
<br>
Expected Response when success:

```
{
  "status": "success",
  "message": "Order Callback Successfully",
  "error": null,
  "content": {
    "status_code": 200,
    "pick_up": {
        "detail": "dekat rumahnya acung",
        "latitude": "dekat rumahnya acung",
        "longitude": "dekat rumahnya acung"
      },
      "drop_off": {
          "detail": "dekat rumahnya acung",
          "latitude": "dekat rumahnya acung",
          "longitude": "dekat rumahnya acung"
      },
      "orderer": {
          "id": 1,
          "status": "status of customer order",
          "name": "name of customer",
          "phone_number": "phone number of customer"
      },
    "status": "status of order"
  }
}
```

<br>
<h3> Check On Process Order API </h3>
<br>
<br>

End-point: 
```
http://localhost:8000/check-on-process-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/check-on-process-order
```

<br>
Method: POST
<br>
<br>
<br>

Header:

    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets

Json-required: No JSON required

<br>
<br>
Expected Response when success:

```
{
  "status": "success",
  "message": "Order Callback Successfully",
  "error": null,
  "content": {
    "status_code": 200,
    "pick_up": {
        "detail": "dekat rumahnya acung",
        "latitude": "dekat rumahnya acung",
        "longitude": "dekat rumahnya acung"
      },
      "drop_off": {
          "detail": "dekat rumahnya acung",
          "latitude": "dekat rumahnya acung",
          "longitude": "dekat rumahnya acung"
      },
      "orderer": {
          "id": 1,
          "status": "status of customer order",
          "name": "name of customer",
          "phone_number": "phone number of customer"
      },
    "status": "status of order"
  }
}
```

NB: Give Accepted header value with application/json (Accepted: application/json) 