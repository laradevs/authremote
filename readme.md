<p align="center"><img src="https://avatars2.githubusercontent.com/u/51764637?s=200&v=4" height="240"></p>

<p ><h1 align="center">AUTH REMOTE</h1></p>

It is a component that allows to carry out and manage the authentication control through OAUTH2.0 for a Laravel application.

### Installation

You can install the package via composer :

```bash
$ composer require laradevs/authremote
```

Next, You must register the service provider (optional) :

```php
// config/app.php

'Providers' => [
   // ...
    \LaraDevs\AuthRemote\MainServiceProvider::class,
]
```

Next, you must publish the configuration file to define the OAUTH server credentials:

```bash
php artisan vendor:publish --provider="LaraDevs\AuthRemote\RestUserServiceProvider"
```

This is the contents of the published file :

```php
return [
    'uri' => env('USER_PROVIDER_REST_URL', ''),
    'name_session_rest' => 'token_oauth',
    'headers' => [],
    'route_not_session'=>'start_route'
];
```

Set your URL Rest in `.env` file :

```
APP_NAME="Laravel"
# ...
USER_PROVIDER_REST_URL=putYourRestURL
```

### Add in Array Services

```php
'laravelpassport' => [
        'client_id' => env('LARAVELPASSPORT_KEY'),
        'client_secret' => env('LARAVELPASSPORT_SECRET'),
        'redirect' => env('LARAVELPASSPORT_REDIRECT_URI'),
        'host'=> env('LARAVELPASSPORT_HOST')
    ]
```
### Add in Handle Exception in method render
```php
 if ($exception instanceof \LaraDevs\AuthRemote\RestException) {
            return redirect()->route(config('rest-provider.route_not_session'));
 }
```
### Add in Array Auth
```php
  'providers' => [
        'users' => [
            'driver' => 'rest-users',
            'model' => \LaraDevs\AuthRemote\User::class
        ],
  ]
```

### Route Login & Logout published automatic

```php
Route::get('/auth-remote/{provider}', '\LaraDevs\AuthRemote\ActionsController@redirectToProvider')->name('laravel_passport');
Route::get('/auth-remote/{provider}/callback', '\LaraDevs\AuthRemote\ActionsController@handleProviderCallback');
Route::post('/auth-remote-logout','\LaraDevs\AuthRemote\ActionsController@logout')->name('laravel_passport.logout');
```