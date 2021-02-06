<?php

    /**
     * MIT License
     * 
     * Copyright (c) 2021 Denis Z.
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all
     * copies or substantial portions of the Software.
     * 
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
     * SOFTWARE.
    */

    /**
     * Plugin Name:       Sources-World API
     * Plugin URI:        https://github.com/c0de4un/wp-src-world-plugin-api
     * Description:       Sources-World API plugin for WordPress
     * Version:           0.1.1
     * Requires at least: 5.2
     * Requires PHP:      8.0
     * Author:            Denis Z
     * Author URI:        https://github.com/c0de4un
     * License:           MIT
     * License URI:       https://opensource.org/licenses/mit-license.php
     * Text Domain:       srcw
     * Domain Path:       /languages
    */

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // CONSTANTS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    define( 'SRCW_DIR', __DIR__ );

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // USE
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /// DEBUG
    if ( WP_DEBUG ) {

        // SRCWLog
        include_once __DIR__ . '/includes/utils/debug/flogger.php';

        function srcw_track_request_time()
        {
            SRCWLog::info( 'wp-src-world-plugin-api::srcw_track_request_time: request handled for ' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . ' seconds', 'performance' );
        }
        register_shutdown_function( 'srcw_track_request_time' );
        FLogger::getInstance()->setRootDir( SRCW_DIR );

        // SRCWTimer
        include_once __DIR__ . '/includes/utils/debug/timer.php';
    }
    /// DEBUG

    // SRCWDependenciesResolver
    include_once __DIR__ . '/includes/utils/reflection/class-srcw-dep-resolver.php';

    // SRCW
    SRCWDependenciesResolver::includeOnce( 'includes/class-srcw.php' );

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // FUNCTIONS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /** Handles activation of the plugin */
    function srcw_activate()
    {
        if ( WP_DEBUG ) {
            SRCWLog::info( 'wp-src-world-plugin-api::srcw_activate', 'core' );
        }

        SRCW::Activate();
    }
    register_activation_hook( __FILE__, 'srcw_activate' );

    /**
     * Start SRCW
    */
    function srcw_init()
    {
        SRCW::Initialize();
    }
    add_action( 'init', 'srcw_init' );

    /** Handles plugin deactivation */
    function srcw_deactivate()
    {
        if ( WP_DEBUG ) {
            SRCWLog::info( 'wp-src-world-plugin-api::srcw_deactivate', 'core' );
        }

        SRCW::Deactivate();
    }
    register_deactivation_hook( __FILE__, 'srcw_deactivate' );

    /** Handles plugin deinstallation */
    function srcw_uninstall()
    {
        if ( WP_DEBUG ) {
            SRCWLog::info( 'wp-src-world-plugin-api::srcw_uninstall', 'core' );
        }

        SRCW::Uninstall();
    }
    register_uninstall_hook( __FILE__, 'srcw_uninstall' );

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

?>
