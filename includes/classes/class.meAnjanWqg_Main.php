<?php
/**
 * Created by PhpStorm.
 * User: anjan
 * Date: 4/5/15
 * Time: 5:24 PM
 */

class meAnjanWqg_Main {

    /**
     * Holds config data
     *
     * @var array
     */

    private $_config = array();

    /**
     * @var meAnjanWqg_Main
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
     * @return meAnjanWqg_Main
     */

    public static function getInstance() {

        if(self::$_instance === NULL) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Init the plugin. which loads config data, registers actions, filters, and other stuff
     */

    public function init() {

        /**
         * Load config
         */

        $this->loadConfig();

        /**
         * Add actions
         */

        $actions = new meAnjanWqg_Actions();

        $actions->init();

        /**
         * Add Filters
         */

        $filters = new meAnjanWqg_Filters();

        $filters->init();

    }

    /**
     * Load config from file and save into _config
     */

    public function loadConfig() {

        $configFile = ME_ANJAN_PLUGIN_WQG_DIR.'config.php';

        if(file_exists($configFile)) {
            $this->_config = require($configFile);
        } else {
            $this->_config = array();
        }

    }

    /**
     * Get config
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */

    public function getConfig( $key = '', $default = null) {

        $key = trim($key);

        if($key == '') {
            return $this->_config;
        }

        return meAnjanWqg_Utils::arrayValue($this->_config,$key,$default);

    }

}