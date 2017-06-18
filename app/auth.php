<?php

use Core\Facades\Auth;

//Set sign in and sign in check routes
Auth::setSignInRoute('/sign_in/');
Auth::setSignInCheckRoute('/sign_in/check/');

//Define anonymous routes
//Auth::addAnonymousRoute();   


