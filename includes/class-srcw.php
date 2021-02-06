<?php

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// CLASS
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

final class SRCW
{

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTANTS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                          FIELDS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /** @var SRCW */
    private static $instance;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTRUCTOR
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    private function __construct()
    {
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                     GETTERS & SETTERS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    /** @return SRCW */
    public static function getInstance()
    { return self::$instance; }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       METHODS.PUBLIC
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /** Initialize SRCW instance */
    public static function Activate()
    {
        if ( self::initializeInstance() ) {
            self::$instance->Install();
        }
    }

    public static function auth()
    {
        if ( WP_DEBUG ) {
            SRCWLog::warning( 'SRCW::auth' );
        }
    }

    /**
     * Start & load
    */
    public static function Initialize()
    {
        if ( WP_DEBUG ) {
            SRCWLog::info( 'SRCW::Initialize' );
        }

        self::initializeInstance();

        // API
        SRCWDependenciesResolver::includeOnce( 'includes/resolvers/class-srcw-router.php' );
        SRCWRouter::getInstance()->registerApiRoutes();

        // Hooks

    }

    /** Terminate SRCW instance */
    public static function Deactivate()
    {
        self::initializeInstance();

        self::$instance->Uninstall();
    }

    /** Uninstall SRCW */
    public static function Uninstall()
    {
        include_once SRCW_DIR . '/includes/db/class-srcw-db.php';

        SRCWDataBase::Uninstall();
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                      METHODS.PRIVATE
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Initialize SRCW instance
     * 
     * @return Boolean - 'true' if instance created, 'false' if already exists
    */
    private static function initializeInstance()
    {
        if ( empty(self::$instance) ) {
            self::$instance = new SRCW();

            return true;
        }

        return false;
    }

    /** Install SRCW */
    private function Install()
    {
        if ( WP_DEBUG ) {

        }
        include_once SRCW_DIR . '/includes/db/class-srcw-db.php';

        SRCWDataBase::Install();
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

}

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
