<?php

//We need it to be done, becouse getRouteUriPieceRelation implicitly use
//$this->routes which forming by Route::go->getAll().
require_once(TESTS_PATH.'Route/getAll.php');

$route_piece = '{slug}';

Debug::dump($route_piece, '$route_piece');

$uri_piece = 'show';

Debug::dump($uri_piece, '$uri_piece');

$route_str = '/blog/{slug}';

Debug::dump($route_str, '$route_str');

Debug::dump($routes[$route_str], '$routes['.$route_str.']');

$relation = Route::go()->getRouteUriPieceRelation($route_piece, $uri_piece, $route_str);

Debug::dump($relation, '$relation');
