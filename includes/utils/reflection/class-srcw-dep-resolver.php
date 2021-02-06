<?php

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// CLASS
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

final class SRCWDependenciesResolver
{

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       META & TRAITS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTANTS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                          FIELDS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTRUCTOR
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                     GETTERS & SETTERS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       METHODS.PUBLIC
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Include-once php-script
     * 
     * @param String||Array[String] $relative_path - relative path from plugin-dir,
     * means don't concat __DIR__ with it, this class handles it
    */
    public static function includeOnce( $relative_path )
    {
        if ( is_array($relative_path) ) {
            foreach( $relative_path as $path )
            {
                self::handleInclude( $path );
            }
        } else {
            self::handleInclude( $relative_path );
        }
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                      METHODS.PRIVATE
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Handles php-script include-logic
     * 
     * @param String $relative_path
    */
    private static function handleInclude( string $relative_path )
    {
        if ( WP_DEBUG ) {
            $include_timer = new SRCWTimer();
        }

        require_once( SRCW_DIR . "/{$relative_path}" );

        if ( WP_DEBUG ) {
            SRCWLog::verbose( "SRCWDependenciesResolver::handleInclude: <{$relative_path}> is included for <{$include_timer->getMicrosecondsElapsed()}> seconds", 'performance' );
        }
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

};

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
