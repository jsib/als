<?php
/* 
 * Provide methods for organizing routing
 */
class Route
{
    /**
     * Define how params in routes should look
     */
    const ROUTE_PARAMS_PATTERN = "/^\{([a-zA-Z\_]+)\}$/";
    
    /**
     * Keep possible ralations between piece of route and uri
     */
    const ROUTE_URI_RELATIONS = ['equal', 'requirement_sutisfied', 'has_param'];
    
    /**
     * Keep information about all routes resolution to controllers and actions
     */
    public $routes = array();
    
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
     * Creates instance of object or get it if instance was created already
     */
    public static function go()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    
    /**
     * Add route to routes array
    */
    public function add($path_input, $controller_action_str, $requirements = null)
    {
        //Get controller and action name
        $controller_action = explode(":", trim($controller_action_str));
        
        //Remove backspaces at the edges if some present
        $path = trim($path_input);
        
        //Push retrieved data to routes array
        $this->routes[$path]['controller'] = $controller_action[0];
        $this->routes[$path]['action'] = $controller_action[1];
        
        //Push requirements to routes array if some presented
        if ($requirements !== null) {
            $this->routes[$path]['requirements'] = $requirements;
        }
        
        return self::$_instance;
    }
    
    /**
     * Get all routes
     */
    public function getAll()
    {
        return $this->routes;
    }
    
    /**
     * Build detailed array with all routes
     */
    public function build()
    {
        foreach ($this->routes as $route_uri => $route_array) {
            $this->routes[$route_uri]['path'] = Uri::parse($route_uri)->getPath();
        }
        
        return self::$_instance;
    }
    
    
    /**
     * Uniquily find route by uri from client
     */
    public function findRouteByClientUri()
    {
        //Transform uri string from client to array
        $uri = Uri::parse()->getPath();
        
        //Start working with all existing routes
        $routes = $this->routes;
        
        //Base route was found in uri and routes arrays
        if ($uri === '/' && isset($routes['/'])) {
            return '/';
        }
        
        //Base route was found in uri, but there is no such route in routes array
        if ($uri === '/' && !isset($routes['/'])) {
            return false;
        }
        
        //Let's remove routes which number of pieces different with uri
        $sized_routes = $this->removeRoutesUnsizedWithUri($routes, $uri);
        
        //There is no routes after removing
        if ($sized_routes === false) {
            return false;
        }
        
        //Iterate over pieces in path of uri from client
        foreach(array_keys($uri) as $uri_piece_key) {
            //Filter routes, leave only that have relation with uri piece
            //on current loop step
            $routes_final = $this->filterRoutesByUriPiece($sized_routes, $uri, $uri_piece_key);
        }
        
        if (count($routes_final) > 0) {
            return $routes_final;
        }
        
        return false;
    }
    
    /**
     * Get param pure route param name
     * 
     * @return  Return param name cleared from braces, and false if param
     * doesn't matches regular expression
     */
    public function getParam($param_in_braces)
    {   
        //Check if param matches regular expression
        if (preg_match(self::ROUTE_PARAMS_PATTERN, $param_in_braces, $matches)) {
            return $matches[1];
        }
        
        return false;
    }
    
    /**
     * Get route parameter requirement
     */
    public function getParamRequirement($route_str, $param_name)
    {
        if (isset($this->routes[$route_str]['requirements'][$param_name])) {
            return $this->routes[$route_str]['requirements'][$param_name];
        }
         
        return false;
    }
    /**
     * Check if parameter requirement executes
     */
    public function checkParamRequirement($route_str, $param_name, $uri_piece)
    {
        $requirement = $this->getParamRequirement($route_str, $param_name);
        
        if ($requirement === false) {
            Debug::error(
                "Requirement for parameter ".$param_name." in route ".
                $route_str." doesn't exist"
            );
        }
        
        $check_result = preg_match('/^'.$requirement.'$/', $uri_piece);
        
        if ($check_result === false) {
            Debug::error("preg_match error");
        }
        
        return (bool) $check_result;
    }
    
    /**
     * Find routes which meet given uri piece.
     * 
     * @param array $routes Routes which we still have after comparison 
     *    of previous piece.
     * @param integer $uri_piece_key Specifies key of piece in given uri
     *    starting from zero.
     * @param string  $uri Uri which piece we use to compare.
     * 
     * @return mixed Return array with all found routes
     *    or false if nothing was found.
     */
    public function filterRoutesByUriPiece($routes, $uri, $uri_piece_key)
    {
        //Keep all found routes grouped by certain relation
        $relation_routes = [];
                
        //Get piece from uri by key
        $uri_piece = $uri[$uri_piece_key];
        
        //Loop over routes which we still have after comparison of previous
        //piece and find any, which has one of relation declared in
        //self::ROUTE_URI_RELATIONS
        foreach ($routes as $route_str => $route) {
            //Extract piece from route with same key as given uri piece has
            $route_piece = $route['path'][$uri_piece_key];
            
            //Get relation between piece of route and uri
            $relation = $this->getRouteUriPieceRelation($route_piece, $uri_piece, $route_str);
            
            if ($relation !== false) {
                $relation_routes[$relation][$route_str] = $route;
            }
        }
        
        //Find relation, which has highest priority
        $winner_relation = $this->findHighestPriorityRelation($relation_routes);
        
        if ($winner_relation !== false) {
            return $relation_routes[$winner_relation];
        }
        
        return false;
    }
    
    /**
     * Get what the relation stand between piece of route and piece of uri.
     * 
     * @param string $route_piece Piece of route path.
     * @param string $uri_piece Piece of uri path.
     * @param string $route_str Route which piece we have.
     * 
     * @return mixed Return string with name of relation between given route piece
     *    and uri piece. And false if there is no relation was found.
     */
    public function getRouteUriPieceRelation($route_piece, $uri_piece, $route_str) {
        //Extract route param name without braces if this piece is param
        $param_name = $this->getParam($route_piece);
        
        //Variant 1: path piece is not a parameter,
        //so we just compare pieces are equal or not
        if ($route_piece === $uri_piece) {
            return 'equal';
        }

        //Variant 2: path piece is a parameter and parameter has requirements
        if ($param_name !== false &&
            $this->routeHasRequirements($route_str) &&
            $this->checkParamRequirement($route_str, $param_name, $uri_piece)
        ) {
            return 'requirement_sutisfied';
        }

        //Variant 3: path piece is a parameter and parameter doesn't have requirements
        if ($param_name !== false &&
            !$this->routeHasRequirements($route_str)
        ) {
           return 'has_param';
        }
        
        return false;
    }
    
    /**
     * Remove routes which have number of pieces defferent from uri.
     * 
     * @param array $routes Full routes arrays.
     * @param array $uri Pieces of uri path, i.e. first part before '?'.
     * 
     * @return array Routes purified from unsized with uri.
     */
    public function removeRoutesUnsizedWithUri($routes, $uri)
    {
        foreach ($routes as $route_str => $route) {
            if (count($route['path']) != count($uri)) {
                unset($routes[$route_str]);
            }
        }
        
        if (count($routes) === 0) {
            return false;
        }
        
        return $routes;
    }
    
    /**
     * Find relation which has highest priority in routes grouped by relation.
     * 
     * @param array $relation_routes Routes grouped by relation.
     * 
     * @return mixed String with name of relation.
     *    False if no relation was found.
     */
    private function findHighestPriorityRelation($relation_routes)
    {
        //Loop over relations from high priority to low priority.
        //If number of routes for a relation is positive,
        //then stop looping and recognize this relation as a winner.
        foreach (self::ROUTE_URI_RELATIONS as $relation) {
            if (isset($relation_routes[$relation])) {
                $relation_number = count($relation_routes[$relation]);
            } else {
                $relation_number = 0;
            }
            
            if ($relation_number > 0) {
                return $relation;
            }
        }
        
        //There is no relation was found
        return false;
    }
    
    /**
     * Check if route has requirements
     */
    public function routeHasRequirements($route_str) {
        return isset($this->routes[$route_str]['requirements']);
    }
}