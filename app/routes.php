<?php

/**
 * This file describes routes to controllers&actions
 */

use Core\Facades\Route;

Route::add('/', 'Blog:listPosts');
Route::add('/blog/posts/load/', 'Blog:loadPosts'); 
Route::add('/blog/{post}/', 'Blog:showPost', ['post' => '\d+']);
Route::add('/blog/show', 'Blog:show');
Route::add('/blog/{slug}', 'Blog:slug');
Route::add('/blog/post/add', 'Blog:addPost');
Route::add('/blog/post/remove', 'Blog:removePost');

//Sign in and registration
Route::add('/sign_in/', 'SignIn:form');
Route::add('/sign_in/check/', 'SignIn:check');