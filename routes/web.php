<?php
use Illuminate\Support\Facades\Route;

Route::get('/auth-remote/{provider}', 'ActionsController@redirectToProvider')->name('laravel_passport');
Route::get('/auth-remote/{provider}/callback', 'ActionsController@handleProviderCallback');
Route::post('/auth-remote-logout','ActionsController@logout')->name('laravel_passport.logout');
