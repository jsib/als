<?php

/**
 * This file defines routes to controllers
 */
Route::go()->add('/blog', 'Blog:list');
Route::go()->add('/blog/{post}', 'Blog:post', ['post' => '\d+']);
Route::go()->add('/blog/{post}/{something}', 'Blog:something', ['post' => '\d+']);
Route::go()->add('/blog/show', 'Blog:show');
Route::go()->add('/blog/{slug}', 'Blog:slug');