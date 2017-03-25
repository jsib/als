<?php

use Core\Facades\Route;

/**
 * This file defines routes to controllers
 */
Route::add('/', 'Blog:list');
Route::add('/blog', 'Blog:list');
Route::add('/blog/{post}', 'Blog:post', ['post' => '\d+']);
Route::add('/blog/{post}/{something}', 'Blog:something', ['post' => '\d+']);
Route::add('/blog/show', 'Blog:show');
Route::add('/blog/{slug}', 'Blog:slug');

Route::add('/check_login/', 'Login:check');