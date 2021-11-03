<?php

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// CLASS
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

final class SRCWRouter
{

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTANTS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * 
     * @var Array[String=>Array[String=>Mix]]
     * @example
     * [
     *     'api'  => [
     *         'srcw/v1' => [
     *             'auth'   => [
     *                 'methods'      => 'POST',
     *                 'controller'   => 'includes/controllers/class-srcw-auth-controller'
     *             ],
     *         ],
     *     ],
     * ]
    */
    private $routes = [];

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                          FIELDS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    /** @var SRCWRouter */
    private static $instance = null;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTRUCTOR
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    private function __construct()
    {
        $this->routes = include( SRCW_DIR . '/configs/api/routes.php' );

        if ( WP_DEBUG ) {
            if ( empty($this->routes) ) {
                throw new Exception( 'SRCWRouter::__construct: no route configs were found' );
            }
        }
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                     GETTERS & SETTERS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    /** @return SRCWRouter */
    public static function getInstance()
    {
        self::initializeInstance();

        return self::$instance;
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       METHODS.PUBLIC
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public static function handleRequest()
    {

    }

    /**
     * Register API routes
    */
    public function registerApiRoutes()
    {
        if ( WP_DEBUG ) {
            SRCWLog::verbose( 'SRCWRouter::registerRoutes' );
        }

        $api_routes = $this->routes['api'];
        if ( WP_DEBUG && empty($api_routes) ) {
            throw new Exception( 'SRCWRouter::registerApiRoutes: not api routes were found' );
        }

        foreach( $api_routes as $namespace => $routes )
        {
            if ( WP_DEBUG && empty($routes) ) {
                SRCWLog::warning( 'SRCWRouter::registerRoutes: empty routes for namespace <{$namespace}>, skipping' );
                continue;
            }

            foreach( $routes as $route_name => $route_config )
            {
                if ( WP_DEBUG ) {
                    if ( empty($route_config) ) {
                        SRCWLog::warning( "SRCWRouter::registerRoutes: empty route config for <{$namespace}>::<{$route_name}>, skipping" );
                        continue;
                    }

                    if ( empty($route_config['methods']) ) {
                        throw new Exception( "SRCWRouter::registerRoutes: empty route config for <{$namespace}>::<{$route_name}>: methods not set" );
                    }

                    if ( empty($route_config['controller']) ) {
                        throw new Exception( "SRCWRouter::registerRoutes: empty route config for <{$namespace}>::<{$route_name}>: controller not set" );
                    }

                    if ( empty($route_config['class']) ) {
                        throw new Exception( "SRCWRouter::registerRoutes: empty route config for <{$namespace}>::<{$route_name}>: class not set" );
                    }
                }

                register_rest_route( $namespace, "/{$route_name}", [
                    'methods'         => $route_config['methods'],
                    'callback'        => function( $request ) use ($route_name, $route_config) {
                        if ( WP_DEBUG ) {
                            SRCWLog::warning( "SRCWRouter::registerRoutes: including controller {$route_config['class']}" );
                        }

                        SRCWDependenciesResolver::includeOnce( $route_config['controller'] );
                        $controller = new $route_config['class']();

                        if ( WP_DEBUG ) {
                            SRCWLog::warning( "SRCWRouter::registerRoutes: calling {$route_config['class']}::{$route_name}" );
                        }

                        $function = !empty($route_config['function']) ? $route_config['function'] : $route_name;

                        return $controller->$function( $request );
                    },
                    'permission_callback' => function() {
                        return true;
                    },
                ] );
            }
        }
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                     METHODS.PROTECTED
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                      METHODS.PRIVATE
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /** Initialize SRCWRouter instance */
    private static function initializeInstance()
    {
        if ( empty(self::$instance) ) {
            self::$instance = new SRCWRouter();
        }
    }
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

};

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
