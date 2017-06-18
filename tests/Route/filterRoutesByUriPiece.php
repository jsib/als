<?php

//Take $sized_routes and $uri from here
require_once(TESTS_PATH.'Route/removeRoutesUnsizedWithUri.php');

$uri_piece_key = 1;

Debug::dump($uri_piece_key, '$uri_piece_key');

$routes_filtered = Route::go()->filterRoutesByUriPiece($sized_routes, $uri, $uri_piece_key);

Debug::dump($routes_filtered, '$routes_filtered');
