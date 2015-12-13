<?php

    /*
        Plugin Name: WP Query Generator
        Description: Allows user to generate WP_Query code to be used in templates/plugins along with letting them preview data
        Author: Anjan Bhowmik
        Version: 1.0
        Author URI: http://anjan.me/

        License: GPL2
        Copyright 2013	Anjan Bhowmik	(email : anjan011@gmail.com)
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License, version 2, as
        published by the Free Software Foundation.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */

    /* Plugin nice name */

    define('ME_ANJAN_PLUGIN_WQG_NICE_NAME','WP_Query Generator');

    /* Minimum PHP version required */

    define('ME_ANJAN_PLUGIN_WQG_MIN_PHP_VERSION','5.4');

    /* text domain */

    define ( 'ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN', 'wp_query_generator' );

    /* On activation check for required php version */

    register_activation_hook( __FILE__, 'meAnjanWqg_ActivationHook' );

    function meAnjanWqg_ActivationHook() {

        if(!version_compare(PHP_VERSION,ME_ANJAN_PLUGIN_WQG_MIN_PHP_VERSION,'>=')) {

            wp_die(( ME_ANJAN_PLUGIN_WQG_NICE_NAME.' requires PHP version <strong>'.ME_ANJAN_PLUGIN_WQG_MIN_PHP_VERSION.'</strong> or higher, your PHP version is <strong>'.PHP_VERSION.'</strong>!' ));

        }

    }

    /* If PHP version does't match, Deactivate plugin! Practically this should never happen, right? */

    if(!version_compare(PHP_VERSION,ME_ANJAN_PLUGIN_WQG_MIN_PHP_VERSION,'>=')) {

        add_action( 'admin_notices', 'meAnjanWqg_DisabledNotice' );

        function meAnjanWqg_DisabledNotice() {

            echo '<div class="error"><p>' . esc_html__( ME_ANJAN_PLUGIN_WQG_NICE_NAME.' is now deactivated, because it requires PHP version '.ME_ANJAN_PLUGIN_WQG_MIN_PHP_VERSION.' or higher, but you PHP version is '.PHP_VERSION.'!', 'my-plugin' ) . '</p></div>';

        }

        /* Was plugin already activated? deactivate it! */

        add_action( 'admin_init', 'meAnjanWqg_DeactivatePlugin' );

        function meAnjanWqg_DeactivatePlugin() {

            deactivate_plugins(plugin_basename(__FILE__));

        }

        return;

    }


    /* plugin base file path */

    define ( 'ME_ANJAN_PLUGIN_WQG_BASE_FILE_PATH', plugin_basename ( __FILE__ ) );



    /* Plugin dir root */

    define ( 'ME_ANJAN_PLUGIN_WQG_DIR', plugin_dir_path ( __FILE__ ) );

    /* Plugin dir url */

    define ( 'ME_ANJAN_WQG_URL_ROOT', plugin_dir_url ( __FILE__ ) );

    /* Auto Load Classes */

    function meAnjanPluginWqgAutoLoader ( $className ) {

        $classDir = ME_ANJAN_PLUGIN_WQG_DIR . '/includes/classes/';

        $fileName = $classDir . 'class.' . $className . '.php';

        if ( file_exists ( $fileName ) ) {
            require_once ( $fileName );
        }

    }

    spl_autoload_register ( 'meAnjanPluginWqgAutoLoader' );

    /* Start the process */

    meAnjanWqg_Main::getInstance ()->init ();
