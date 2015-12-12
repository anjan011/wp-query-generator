<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 10/11/15
     * Time: 10:44 PM
     */
    class meAnjanWqg_Taxonomies {

        /**
         * Get list of taxonomies
         *
         * @param array $params
         *
         * @return array
         */

        public static function getTaxonomies( $params = array()) {

            $params = isset($params) ? $params : array();

            $args = meAnjanWqg_Utils::arrayValue($params,'args');
            $output = meAnjanWqg_Utils::arrayValue($params,'output','names');
            $operator = meAnjanWqg_Utils::arrayValue($params,'operator','and');

            return get_taxonomies($args,$output,$operator);

        }

        /**
         * Get taxonomy terms
         *
         * @param array $params
         *
         * @return array|WP_Error
         */

        public static function getAllTerms( $params = array()) {

            $taxonomy = meAnjanWqg_Utils::arrayValueAsString($params,'taxonomy','','trim');
            $field = meAnjanWqg_Utils::arrayValueAsString($params,'field','','trim');

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