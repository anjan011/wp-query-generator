<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/15/15
     * Time: 11:59 AM
     */
    class meAnjanWqg_Utils {

        /**
         * Directly prints/returns a value from $_POST
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function post( $key, $default = NULL, $return = TRUE ) {

            $data = self::arrayValue( $_POST, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Get array value.
         *
         * It takes the array and a key name or a key path to access element in multidimensional array
         *
         * @param array  $array   The array to conduct the search on
         * @param string $key     The Key name or key path (a/b/c/d)
         * @param mixed  $default The default value
         *
         * @return mixed
         */

        public static function arrayValue( $array, $key, $default = NULL ) {

            if ( !is_array( $array ) ) {
                return $default;
            }

            $key = trim( trim( $key ), '/' );

            $parts = explode( '/', $key );

            foreach ( $parts as $p ) {

                $array = isset($array[ $p ]) ? $array[ $p ] : NULL;

                if ( $array === NULL ) {
                    return $default;
                }
            }

            return $array;
        }

        /**
         * Directly prints/returns a value from $_GET
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function get( $key, $default = NULL, $return = TRUE ) {

            $data = self::arrayValue( $_GET, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_SESSION
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function session( $key, $default = NULL, $return = TRUE ) {

            $data = self::arrayValue( $_SESSION, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_SERVER
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function server( $key, $default = NULL, $return = TRUE ) {

            $data = self::arrayValue( $_SERVER, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_COOKIE
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function cookie( $key, $default = NULL, $return = TRUE ) {

            $data = self::arrayValue( $_COOKIE, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Generates a line with indent and line feeds
         *
         * @param int    $tabs
         * @param string $message
         * @param int    $newlines
         *
         * @return string
         */

        public static function _l( $tabs = 0, $message = '', $newlines = 1 ) {

            $tabs = (int) $tabs;

            if ( $tabs < 0 ) {
                $tabs = 0;
            }

            $newlines = (int) $newlines;

            if ( $newlines < 0 ) {
                $newlines = 0;
            }

            return str_repeat("\t",$tabs).$message.str_repeat("\n",$newlines);
        }

        /**
         * Generate "selected" attr for dropdown/lists by comparing values
         *
         * @param array  $source
         * @param string $key
         * @param string $value_to_match
         * @param bool   $multiple
         */

        public static function selectedAttr( $source = array(), $key = '', $value_to_match = '', $multiple = false) {

            if(!$multiple) {
                if(self::arrayValue($source,$key) == $value_to_match) {
                    echo 'selected';
                }
            } else {

                $values = self::arrayValue($source,$key);

                if(!is_array($values)) {
                    $values = array();
                }

                if(in_array($value_to_match,$values)) {
                    echo 'selected';
                }

            }


        }

        /**
         * Generates a wp ajax url using given action name and optional extra params
         *
         * @param string $action
         * @param array  $extra_params
         *
         * @return bool|string|void
         */

        public static function wpAjaxUrl( $action = '', $extra_params = array()) {

            $action = trim($action);

            if($action == '') {
                return false;
            }

            $extra_params = is_array($extra_params) ? $extra_params : array();

            $extra_params['action'] = $action;

            return admin_url( 'admin-ajax.php?'.http_build_query($extra_params));

        }

        /**
         * Save data in options
         *
         * @param array $data
         */

        public static function saveData( $data = array()) {

            $key = 'me_anjan_plugins_wqg_data';

            update_option($key,$data);

        }

        /**
         * Get data from options
         *
         * @return mixed|void
         */

        public static function getData() {

            $key = 'me_anjan_plugins_wqg_data';

            return get_option($key);

        }

        /**
         * Get array value as an Integer
         *
         * @param array  $array
         * @param string $key
         * @param int    $default
         * @param null   $callback
         *
         * @return int|mixed
         */

        public static function arrayValueAsInt( $array = array(), $key = '', $default = 0, $callback = null) {

            $value = (int)self::arrayValue($array,$key,$default);

            if(is_callable($callback)) {
                return call_user_func($callback,$value);
            }

            return $value;

        }

        /**
         * Get array value as float
         *
         * @param array  $array
         * @param string $key
         * @param int    $default
         * @param null   $callback
         *
         * @return int|mixed
         */

        public static function arrayValueAsFloat( $array = array(), $key = '', $default = 0, $callback = null) {

            $value = (float)self::arrayValue($array,$key,$default);

            if(is_callable($callback)) {
                return call_user_func($callback,$value);
            }

            return $value;

        }

        /**
         * Get array value as an Integer
         *
         * @param array  $array
         * @param string $key
         * @param int    $default
         * @param null   $callback
         *
         * @return int|mixed
         */

        public static function arrayValueAsArray( $array = array(), $key = '', $default = 0, $callback = null) {

            $value = self::arrayValue($array,$key,$default);

            if(!is_array($value)) {
                $value = array();
            }

            if(is_callable($callback)) {
                return call_user_func($callback,$value);
            }

            return $value;

        }

        /**
         * Array value as string
         *
         * @param array      $array
         * @param string     $key
         * @param string $default
         * @param null       $callback
         *
         * @return mixed|string
         */

        public static function arrayValueAsString( $array = array(), $key = '', $default = '', $callback = null) {

            $value = self::arrayValue($array,$key,$default);

            if(!is_string($value)) {
                $value = '';
            }

            if(is_callable($callback)) {
                return call_user_func($callback,$value);
            }

            return $value;

        }

        /**
         * Is current wordpress version greater or equal to given version?
         *
         * @param string $version
         *
         * @return bool|mixed
         */

        public static function isMinWpVersion( $version = '') {

            $version = trim($version);

            if(!$version) {
                return false;
            }

            $current_version = get_bloginfo('version');

            return version_compare($current_version,$version,'>=');

        }

    }