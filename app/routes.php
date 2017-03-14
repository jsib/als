<?php

/**
 * This file defines routes to controllers
 */
Route::add('/blog', 'Blog:list');
Route::add('/blog/{post}', 'Blog:show', ['{post}' => '\d+']);
Route::add('/blog/show', 'Blog:show');
Route::add('/blog/{slug}', 'Blog:show');