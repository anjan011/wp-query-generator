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

    /* plugin base file path */

    define ( 'ME_ANJAN_PLUGIN_WQG_BASE_FILE_PATH', plugin_basename ( __FILE__ ) );

    /* text domain */

    define ( 'ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN', 'wp_query_generator' );

    /* Plugin dir root */

    define ( 'ME_ANJAN_PLUGIN_WQG_DIR', plugin_dir_path ( __FILE__ ) );

    /* Plugin dir url */

    define ( 'ME_ANJAN_PLUGIN_WQG_URL', plugin_dir_url ( __FILE__ ) );

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

    wqg_main::get_instance ()->init ();
