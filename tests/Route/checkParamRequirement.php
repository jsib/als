<?php

$route_str = '/blog/{post}';

Debug::dump($route_str, '$route_str');

$param_name = 'post';

Debug::dump($param_name, '$param_name');

$uri_piece = 'dfd';

Debug::dump($uri_piece, '$uri_piece');


Debug::dump(
    Route::go()->checkParamRequirement(
        $route_str,
        $param_name,
        $uri_piece
    ), 
    'checkParamRequirement()'
);

