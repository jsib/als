<?php
/* 
 * Provide methods for organizing routing
 */
class Route
{
    /**
     * Keep information about all routes resolution to controllers and actions
     */
    public static $routes = array();
    
    /**
     * Keep instance of this class object, needed to make singleton 
     */
    private static $_instance = null;
    
    /**
     * Forbid creating object through 'new' directive to make singleton
     */
    private function __construct() {/* ... */}

    /**
     * Forbid cloning object to make singleton
     */
    private function __clone() {/* ... */}
    
    /**
     * Forbid unserialize to make singleton
     */
    private function __wakeup() {/* ... */}
    
    /**
     * Add new route
    */
    public static function add($path, $controller_action_str, $requirements = null)
    {
        //Get controller and action name
        $controller_action = explode(":", trim($controller_action_str));
        
        //Remove backspaces at the edges if some present
        $path = trim($path);
        
        //Push retrieved data to special array
        self::$routes[$path]['controller'] = $controller_action[0];
        self::$routes[$path]['action'] = $controller_action[1];
        
        //Push requirements if presented
        if ($requirements !== null) {
            self::$routes[$path]['requirements'] = $requirements;
        }
        
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    
    /**
     * Get all routes
     */
    public static function getAll()
    {
        $routes = [];
        
        foreach (self::$routes as $route_uri => $route_array) {
            self::$routes[$route_uri]['path'] = Uri::parse($route_uri)->getPath();
        }       
        
        return self::$routes;
    }
    
    /**
     * Definitely find controller by current URI
     */
    public static function getRelevant()
    {
        $current_uri = Uri::parse()->getPath();
        $routes = self::$routes;
        
        //Iterate over pieces in path of uri from client
        foreach($current_uri as $uri_key => $uri_path_piece) {
            //Array for controversial routes
            $routes_controversial = [];
            $choosen_route_uri = '';
            
            //Iterate over all routes. Here we use 'continue' to not delete
            //route from routes array and start check it with other 
            //controversial routes. Otherwise we let route to be checked
            //with next piece in given uri.
            foreach ($routes as $route_uri => $route) {
                //Delete routes which path pieces count are different from given 
                //uri
                if (count($route['path']) != count($current_uri)) {
                    unset($routes[$route_uri]);
                    continue;
                }
                
                //Extract piece in route path with same number with uri path piece
                $route_path_piece = $route['path'][$uri_key];
                
                //First, check if path piece is parameter
                if (self::isParam($route_path_piece)) {
                    //Path pieces with requirements have superiority
                    //over pieces which doesn't have requirements.
                    //There is no separation between types of requirements.
                    if (isset($route['requirements'][$route_path_piece])) {
                        $routes_controversial['has_param_with_requirement'] = $route_uri;
                        continue;
                    }
                    
                    //Path pieces without requirements
                    $routes_controversial['has_param'] = $route_uri;
                    continue;
                }
                
                //For path pieces which are not params
                if ($route_path_piece == $uri_path_piece) {
                    $routes_controversial['equal'] = $route_uri;
                    continue;
                }
                
                //Delete routes which are not fit criterias above
                unset($routes[$route_uri]);
            }
            
            Debug::dump($uri_path_piece, '$uri_path_piece');
            Debug::dump($routes_controversial, '$routes_controversial');
            
            //Choose among controversial routes strictly in this order
            foreach (['equal', 'has_param_with_requirement', 'has_param'] as $contr) {
                if ($choosen_route_uri === '') {
                    if (isset($routes_controversial[$contr])) {
                        $choosen_route_uri = $routes_controversial[$contr];
                    }
                } else {
                    if (isset($routes_controversial[$contr])) {
                        //Delete route becouse we found other one with higher priority
                        unset($routes[$routes_controversial[$contr]]);
                    }
                }
            }
            
            if ($choosen_route_uri === '') {
                Debug::error('No route found');
            }
            
        }
        
        Debug::dump($current_uri, '$current_uri');
        Debug::dump($routes, '$routes');
        
        //Check for base route
        if (count($current_uri) == 0) {
            $route = "/";
        }
        
        $route_uri = Uri::parse('/route/test')->getPath();
        Debug::dump($route_uri, '$route_uri');
        
    }
    
    /**
     * Define if piece of route path is parameter
     */
    public static function isParam($route_piece)
    {
        if (
            substr($route_piece, 0, 1) == '{' &&
            substr($route_piece, -1, 1) == '}'
        ) {
            return true;
        }
        
        return false;
    }
}