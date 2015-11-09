<?php

    /*
        Plugin Name: WP Query Generator
        Description: Allows user to generate WP_Query code to be used in templates/plugins
        Author: Anjan Bhowmik
        Version: 1.0
    */

    /* plugin base file path */

    define('ME_ANJAN_PLUGIN_WQG_BASE_FILE_PATH',plugin_basename(__FILE__));

    /* text domain */

    define('ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN','wp_query_generator');

    /* Plugin dir root */

    define('ME_ANJAN_PLUGIN_WQG_DIR',plugin_dir_path(__FILE__));

    /* Plugin dir url */

    define('ME_ANJAN_PLUGIN_WQG_URL',plugin_dir_url(__FILE__));

    /* Auto Load Classes */

    function me_anjan_plugin_wqg_auto_loader($className) {

        $classDir = ME_ANJAN_PLUGIN_WQG_DIR.'/includes/classes/';

        $fileName = $classDir.'class.'.$className.'.php';

        if(file_exists($fileName)) {
            require_once($fileName);
        }

    }

    spl_autoload_register('me_anjan_plugin_wqg_auto_loader');

    /* Start the process */

    wqg_main::get_instance()->init();
