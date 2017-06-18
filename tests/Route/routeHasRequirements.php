<?php

//We implicitly need $this->routes from here which is used in
//routeHasRequirements() function.
require_once(TESTS_PATH.'Route/getAll.php');

$route_str = '/blog/{post}';

Debug::dump($route_str, '$route_str');

$has_requirements = Route::go()->routeHasRequirements($route_str);

Debug::dump($has_requirements, '$has_requirements');

