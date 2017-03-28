<?php

/**
 * This file describes routes to controllers&actions
 */

use Core\Facades\Route;

Route::add('/', 'Blog:list');
Route::add('/blog', 'Blog:list');
Route::add(
    '/blog/{post}/',
    'Blog:showPost',
    ['post' => '\d+']
);
Route::add('/blog/show', 'Blog:show');
Route::add('/blog/{slug}', 'Blog:slug');

//Sign in and registration
Route::add('/sign_in/', 'SignIn:form');
Route::add('/sign_in/check/', 'SignIn:check');