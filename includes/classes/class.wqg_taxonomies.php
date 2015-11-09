<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 10/11/15
     * Time: 10:44 PM
     */
    class wqg_taxonomies {

        /**
         * get list of taxonomies
         *
         * @param array $params
         *
         * @return array
         */

        public static function get_taxonomies($params = array()) {

            $params = isset($params) ? $params : array();

            $args = wqg_utils::__ARRAY_VALUE($params,'args');
            $output = wqg_utils::__ARRAY_VALUE($params,'output','names');
            $operator = wqg_utils::__ARRAY_VALUE($params,'operator','and');

            return get_taxonomies($args,$output,$operator);

        }

        /**
         * get taxonomy terms
         *
         * @param array $params
         *
         * @return array|WP_Error
         */

        public static function get_all_terms($params = array()) {

            $taxonomy = wqg_utils::array_value_as_string($params,'taxonomy','','trim');
            $field = wqg_utils::array_value_as_string($params,'field','','trim');

            if($field == '') {
                $field = 'term_id';
            }

            switch($field) {
                case 'name':
                case 'term_id':
                case 'slug':
                    break;
                default:
                    $field = 'term_id';
                    break;
            }

            $args = array(
                'orderby'           => 'name',
                'order'             => 'ASC',
                'hide_empty'        => false,
            );

            $res = get_terms($taxonomy,$args);

            $data = array();

            if(is_array($res) && count($res) > 0) {

                foreach($res as $r) {

                    $data[] = array(
                        'label' => $r->name,
                        'value' => $r->$field
                    );

                }

            }

            return $data;

        }

    }