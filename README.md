<div id="top"></div>

<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]



<!-- PROJECT LOGO -->
<h3 align="center">AMBULAN-API</h3>

  <p align="center">
    Api for ambulance system
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#How-To-Use-The-API">How To Use Api</a>
      <ol type="A">
        <li>
          <a href="#authentication-api">Authentication Api</a>
          <ul>
            <li><a href="#register-api">Register Api</a></li>
            <li><a href="#login-api">Login Api</a></li>
            <li><a href="#logout-api">Logout Api</a></li>
          </ul>
        </li>
        <li>
            <a href="#order-api">Order Api</a>
            <ul>
              <li><a href="#make-order-api">Make Order Api</a></li>
              <li><a href="#check-order-api">Check Order Api</a></li>
              <li><a href="#check-on-process-order-api">Check On Process Order Api </a></li>
              <li><a href="#get-driver-for-order-api">Get Driver For Order Api</a></li>
              <li><a href="#driver-response-for-accepting-or-not-for-order-api">Driver Response For Accepting Or Not For Order Api</a></li>
              <li><a href="#check-order-if-accepted-api">Check Order If Accepted Api</a></li>
            </ul>
            </ul>
        </li>
      </ol>
    </li>
  </ol>
</details>

### Built With

* [Laravel](https://laravel.com)

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

You have install composer first for the laravel
You can see the documentations for downloading composer in here [composer-download-url]
<br><br>

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/kuatsaktiterus/AMBULAN-API.git
   ```
2. Install Vendor
   ```sh
   composer install
   ```
3. Setup The .env file  
  For Windows:
   ```sh
   copy .env.example .env
   ```  
   For Linux:
   ```sh
   cp .env.example .env
   ```  
   Then Generate key
   ```sh
   php artisan key:generate
   ``` 
4. Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration. Add API_KEY and fill this with your own api key or you can store in another place like database and do some tweaks.  
For Example:
[![AMBULAN-API][product-screenshot]](https://example.com)
5. Install Sanctum
   ```sh
   composer require laravel/sanctum
   ```  
   publish vendor  
   ```sh
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```  
6. Setup channel for laravel
   * Install pusher
   ```sh
   composer require pusher/pusher-php-server
   ```  
   After install pusher you can go to [pusher] to create your account and setup your own channel
   * Setup .env for pusher
   ```env
   BROADCAST_DRIVER=pusher

   PUSHER_APP_ID=your-pusher-app-id
   PUSHER_APP_KEY=your-pusher-key
   PUSHER_APP_SECRET=your-pusher-secret
   PUSHER_APP_CLUSTER=your-pusher-cluster
   ```
7. Run Migration
   ```
   php artisan migrate
   ```


<p align="right">(<a href="#top">back to top</a>)</p>

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

## How To Use The API
### Authentication API

<br>
Note that there are 3 end-point (login, register, and logout).  

#### Register API  
* End-point:

```
http://localhost:8000/api/register
```

or any url that you have example: 
```
http://(YOUR URI)/api/register
```    
* Method: POST  
* Header:
```
x-api-key: (api key from file .env) # without brackets
```  
* Json-required:
```  
// for driver user
{
  "name": "name of user",
  "phone_number": "phone number",
  "password": "user password",
  "user_role": "user role",
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

* Expected Response when success:

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
    "user_role": "user role",
    "is_ordered": "true or false" // this is parameter for customer or driver(customer user use this to inform if customer already order. Driver use this for inform if driver already have order)    
  }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>


<br>
<br>

#### Login API  

* End-point:
```
http://localhost:8000/api/login
```
or any url that you have example: 
```
http://(your uri)/api/login  
```

* Method: POST  
* Header: 
```
x-api-key = (api key from file .env) # without brackets
```  
* Json-required:
```
{
  "phone_number": "user phone number", 
  "password": "user password" 
}
```  
* Expected response when success:
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
    "user_role": "user role",
    "is_ordered": "true or false" // this is parameter for customer or driver(customer user use this to inform if customer already order. Driver use this for inform if driver already have order)
  }
}

```
<p align="right">(<a href="#top">back to top</a>)</p>


<br>
<br>

#### Logout API  
* End-point: 
```
http://localhost:8000/api/logout
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/logout
```  
* Method: POST  
* Header:
```
x-api-key = (api key from file .env) # without brackets
Authorization = (token_type) (access token) # without brackets  
```

* Json-required: No JSON required  
* Expected Response when success:

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
<p align="right">(<a href="#top">back to top</a>)</p>


### Order API  

#### Make Order API  
* End-point: 
```
http://localhost:8000/api/store-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/store-order
```  
* Method: POST  
* Header:
```
    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets
```
* Json-required:
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
* Expected Response when success:

```
{
  "status": "status of response",
  "message": "message from response",
  "error": 'error',
  "content": {
      "status_code": "code of status",
      "order_id": "iid of order,
      "pick_up": {
          "detail": "pick up detail",
          "latitude": "latitude of pick up",
          "longitude": "longitude of pick up",
      },
      "drop_off": {
          "detail": "drop off detail",
          "latitude": "latitude of drop off",
          "longitude": "longitude of drop off"
      },
      "orderer": {
          "id": "id of orderer,
          "is_ordered": "status if ordered or not,
          "name": "name of orderer(customer)",
          "phone_number": "phone number of orderer(customer)"
      },
      "status": "status of order"
  }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>

<br>
<br>

#### Check Order API  
* End-point: 
```
http://localhost:8000/api/check-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/check-order
```  
* Method: POST  
* Header:
```  
x-api-key = (api key from file .env) # without brackets
Authorization = (token_type) (access token) # without brackets
```  
* Json-required:  
```
// id of order
{
    "order_id": "3"
}
```  
* Expected Response when success:

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
<p align="right">(<a href="#top">back to top</a>)</p>


<br>

#### Check On Process Order API 
This API is for checking if there is any order for the authenticated customer is on going  
* End-point: 
```
http://localhost:8000/api/check-on-process-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/check-on-process-order
```  
* Method: POST  
* Header:
```
x-api-key = (api key from file .env) # without brackets
Authorization = (token_type) (access token) # without brackets
```  
* Json-required: No JSON required  
* Expected Response when success:

```
{
  "status": "status of response",
  "message": "message from response",
  "error": 'error',
  "content": {
      "status_code": "code of status",
      "order_id": "iid of order,
      "pick_up": {
          "detail": "pick up detail",
          "latitude": "latitude of pick up",
          "longitude": "longitude of pick up",
      },
      "drop_off": {
          "detail": "drop off detail",
          "latitude": "latitude of drop off",
          "longitude": "longitude of drop off"
      },
      "orderer": {
          "id": "id of orderer,
          "is_ordered": "status if ordered or not,
          "name": "name of orderer(customer)",
          "phone_number": "phone number of orderer(customer)"
      },
      "status": "status of order"
  }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>


<br>
<br>

#### Get Driver For Order API
This API for getting driver for specific order 
<br>
<br>

* End-point: 
```
http://localhost:8000/api/get-driver
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/get-driver
```
* Method: POST
* Header:

    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets
* Json-required: 
```
{
  "order_id": "id of order data"
}
```
* Expected Response when success:

```
{
    "status": "success",
    "message": "Driver found",
    "error": null,
    "content": {
        "status_code": 200,
        "driver_id": "id of the driver that system get
    }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>

<br>
<br>

#### Driver Response For Accepting Or Not For Order API
This API for driver response for incoming order(accept order or not)  
* End-point: 
```
http://localhost:8000/api/accept-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/accept-order
```
* Method: POST  
* Header:

    x-api-key = (api key from file .env) # without brackets
    Authorization = (token_type) (access token) # without brackets

* Json-required: 
```
{
  "order_id": "id of order,
  "is_accepted": "is order accepted or not" // true or false
}
```
* Expected Response when success:

```
{
    "status": "success",
    "message": "is accepted or rejected", //Order Accepted Or Order Rejected
    "error": null,
    "content": {
        "status_code": 200,
        "order_id": 1
    }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>


#### Check Order If Accepted API  
* End-point: 
```
http://localhost:8000/api/check-accepted-order
```
 or any url that you have example: 
 ```
 http://(YOUR URI)/api/check-accepted-order
```  
* Method: POST  
* Header:
```  
x-api-key = (api key from file .env) # without brackets
Authorization = (token_type) (access token) # without brackets
```  
* Json-required:  
```
// id of order
{
    "order_id": "id of orderer"
}
```  
* Expected Response when success:

```
{
  "status": "status of response",
    "message": "message of response",
    "error": "error",
    "content": {
        "status_code": "200",
        "order_id": "id of order,
        "order_status": "status of order",
        "driver": {
            "id": "id of driver",
            "name": "name of driver",
            "vehicle_name": "name of vehicle",
            "registration_number": "registration number of driver vehicle",
            "latitude": "latitude of driver location",
            "longitude": "longitude of driver location"
        }
    }
}
```
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[forks-shield]: https://img.shields.io/github/forks/kuatsaktiterus/AMBULAN-API.svg?style=for-the-badge
[forks-url]: https://github.com/kuatsaktiterus/AMBULAN-API/network/members
[stars-shield]: https://img.shields.io/github/stars/kuatsaktiterus/AMBULAN-API.svg?style=for-the-badge
[stars-url]: https://github.com/kuatsaktiterus/AMBULAN-API/stargazers
[issues-shield]: https://img.shields.io/github/issues/kuatsaktiterus/AMBULAN-API.svg?style=for-the-badge
[issues-url]: https://github.com/kuatsaktiterus/AMBULAN-API/issues
[product-screenshot]: screenshot/screenshot.jpg
[composer-download-url]:https://getcomposer.org/download/
[pusher]:https://pusher.com/