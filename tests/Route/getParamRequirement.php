<?php

//We implicitly need $this->routes from here which is used in
//getParamRequirement() function.
require_once(TESTS_PATH.'Route/getAll.php');

$route_str = '/blog/{post}';

Debug::dump($route_str, '$route_str');

$param_name = 'post';

Debug::dump($param_name, '$param_name');

$param_requirement = Route::go()->getParamRequirement($route_str, $param_name);

Debug::dump($param_requirement, '$param_requirement');

