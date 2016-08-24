# Simple CMS for Laravel 5.2

This is a Laravel 5 package - https://github.com/glebstar/laravel5-simple-cms

[![GitHub Author](https://img.shields.io/badge/author-@glebstar-lightgrey.svg?style=flat-square)](https://github.com/glebstar)

## Installation

```json
{
    "require": {
        "glebstar/laravel5-simple-cms": "dev-master"
    }
}
```

or run `composer require glebstar/laravel5-simple-cms`

Then run composer update in your terminal to pull it in.

Once this has finished, you will need to add the service provider to the providers array in your app.php config as follows:
```php
GlebStarSimpleCms\ServiceProvider::class,
```

To publish a the package configuration file, run:

```shell
php artisan vendor:publish --provider="GlebStarSimpleCms\ServiceProvider"
```

Added routes for cms pages with your autorization middleware:
```php

Route::group(['prefix' => 'cms', 'middleware' => 'cms'], function(){
    Route::get('/', ['as' => 'cms', 'uses' =>'\GlebStarSimpleCms\Controllers\AdminController@index']);
    Route::match(['get', 'post'], '/add', '\GlebStarSimpleCms\Controllers\AdminController@add');
    Route::match(['get', 'post'], '/edit/{id}', '\GlebStarSimpleCms\Controllers\AdminController@edit');
    Route::delete('/delete/{id}', '\GlebStarSimpleCms\Controllers\AdminController@delete');
});

// this route should be the last.
Route::get('{path}', '\GlebStarSimpleCms\Controllers\CmsController@index')->where('path', '([A-z\d-\/_.]+)?');
```

Appli migration

```shell
php artisan migrate
```

### Configuration

Edit the file config/simplecms.php

Create a layout for cms pages, for example

```php
@extends('layouts.main')

@section('add_title'){{$page->title}}@endsection
@section('description'){{$page->description}}@endsection
@section('keywords'){{$page->keywords}}@endsection

@section('content')
    <div class="container">
        @can('editor')
        <div>
            <a class="btn btn-info" href="{{ route('cms') }}/edit/{{ $page->id }}">Edit</a>
        </div>
        @endcan
        @yield('cmspagebody')
    </div>
@endsection
```

Your layout should have @yield('cmspagebody')

If you need, to edit package layouts in resources/views/vendor/simplecms
