<?php

/* 
 * Test URI class
 */

require_once '../classes/Uri.php';
require_once '../classes/Debug.php';

$uri = Uri::parse();
Debug::dump($uri->getFirstPathPiece());



