<?php
//Take $routes from here
require_once(TESTS_PATH.'Route/getAll.php');

$uri = Uri::parse('/blog/988989/abc/')->getPath();

Debug::dump($uri, '$uri');

$sized_routes = Route::go()->removeRoutesUnsizedWithUri($routes, $uri);

Debug::dump($sized_routes, '$sized_routes');
