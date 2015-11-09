<?php
/**
 * Created by PhpStorm.
 * User: anjan
 * Date: 4/5/15
 * Time: 5:24 PM
 */

class wqg_main {

    /**
     * Holds config data
     *
     * @var array
     */

    private $_config = array();

    /**
     * @var self
     */

    private static $_instance = null;

    /**
     * Block instantiation in normal way, since we r making it a singleton class
     */

    private function __construct() {

    }

    /**
     * Get the instance
     *
     * @return wqg_main
     */

    public static function get_instance() {

        if(self::$_instance === NULL) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Init the plugin. which loads config data, registers actions, filters, and other stuff
     */

    public function init() {

        $this->load_config();

        /**
         * Add actions
         */

        $actions = new wqg_actions();

        $actions->init();

    }

    /**
     * Load config from file
     */

    public function load_config() {

        $this->_config = require(ME_ANJAN_PLUGIN_WQG_DIR.'config.php');

    }

    /**
     * Get config
     *
     * @param string $key
     * @param null   $default
     *
     * @return array|mixed
     */

    public function get_config($key = '',$default = null) {

        $key = trim($key);

        if($key == '') {
            return $this->_config;
        }

        return wqg_utils::__ARRAY_VALUE($this->_config,$key,$default);

    }

}