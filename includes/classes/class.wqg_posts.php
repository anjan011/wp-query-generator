<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 11/8/15
     * Time: 9:36 PM
     */
    class wqg_posts {

        /**
         * get posts
         *
         * @param array $params
         *
         * @return array
         */

        public static function get_posts( $params = array() ) {

            $params = is_array( $params ) ? $params : array();

            $params[ 'post_type' ] = wqg_utils::array_value_as_array( $params, 'post_type', array( 'post' ) );
            $params[ 'order' ] = wqg_utils::array_value_as_string( $params, 'order', 'asc', 'trim' );
            $params[ 'orderby' ] = wqg_utils::array_value_as_string( $params, 'orderby', 'title', 'trim' );
            $params[ 'nopaging' ] = wqg_utils::__ARRAY_VALUE( $params, 'nopaging', TRUE );
            $params[ 'post_parent' ] = wqg_utils::array_value_as_int( $params, 'post_parent', 0 );

            $q = new WP_Query( $params );

            $posts = $q->get_posts();

            return $posts;

        }

        /**
         * generates posts list dropdown
         *
         * @param array $params
         *
         * @return string
         */

        public static function posts_dropdown( $params = array() ) {

            $params[ 'post_type' ] = wqg_utils::array_value_as_array( $params, 'post_type', array( 'post' ) );

            if ( in_array( 'any', $params[ 'post_type' ] ) ) {
                $params[ 'post_type' ] = array( 'any' );
            }

            $attributes = wqg_utils::__ARRAY_VALUE( $params, 'attributes', array() );

            $selected = wqg_utils::__ARRAY_VALUE( $params, 'selected', '' );

            $options_only = isset($params[ 'options_only' ]) && $params[ 'options_only' ];

            $html = '';

            if ( !$options_only ) {


                $html .= "<select";

                if ( is_array( $attributes ) && count( $attributes ) > 0 ) {

                    foreach ( $attributes as $key => $value ) {

                        $html .= " {$key}='".(string) $value."'";

                    }

                }

                $html .= '>';
            }

            $empty_value = wqg_utils::__ARRAY_VALUE( $params, 'empty_value', FALSE );

            if ( is_array( $empty_value ) && isset($empty_value[ 'label' ]) && isset($empty_value[ 'value' ]) ) {

                $html .= "<option value='{$empty_value['value']}'>{$empty_value['label']}</option>";

            }

            foreach ( $params[ 'post_type' ] as $post_type ) {

                $html .= '<optgroup label="'.$post_type.'">';

                $params[ 'post_type' ] = array( $post_type );

                $posts = self::get_posts( $params );

                if ( is_array( $posts ) && count( $posts ) > 0 ) {

                    foreach ( $posts as $p ) {

                        $html .= self::generate_post_option( array(
                            'post_type'   => array( $post_type ),
                            'post'        => $p,
                            'selected'    => $selected,
                            'label_field' => wqg_utils::__ARRAY_VALUE( $params, 'label_field', 'post_title' ),
                            'value_field' => wqg_utils::__ARRAY_VALUE( $params, 'value_field', 'ID' ),
                            'indent'      => 0,
                        ) );

                    }

                }

                $html .= '</optgroup>';

            }


            if ( !$options_only ) {
                $html .= '</select>';
            }


            return $html;

        }

        /**
         * Generates <option> entry for a single post
         *
         * @param array $params
         *
         * @return bool|string
         */

        public static function generate_post_option( $params = array() ) {

            $post = wqg_utils::__ARRAY_VALUE( $params, 'post', FALSE );

            if ( !is_object( $post ) || !($post instanceof WP_Post) ) {
                return FALSE;
            }


            $label_field = wqg_utils::__ARRAY_VALUE( $params, 'label_field', 'post_title' );
            $value_field = wqg_utils::__ARRAY_VALUE( $params, 'value_field', 'ID' );

            $indent = (int) wqg_utils::__ARRAY_VALUE( $params, 'indent', 0 );

            $label = isset($post->$label_field) ? $post->$label_field : '';
            $value = isset($post->$value_field) ? $post->$value_field : '';

            $label = str_repeat( '-', $indent ).$label;

            /* Selected attr */

            $selected_attr = '';

            $selected = wqg_utils::__ARRAY_VALUE( $params, 'selected', '' );

            if ( is_array( $selected ) && in_array( $value, $selected ) ) {
                $selected_attr = ' selected';
            }
            else if ( $selected == $value ) {
                $selected_attr = ' selected';
            }

            $html = "<option value='{$value}'{$selected_attr}>{$label}</option>";

            $params[ 'post_parent' ] = $post->ID;

            $child_posts = self::get_posts( $params );

            /* Child categories */

            if ( is_array( $child_posts ) && count( $child_posts ) > 0 ) {

                foreach ( $child_posts as $p ) {

                    $newParam = $params;

                    $newParam[ 'indent' ] = $indent + 1;

                    $newParam[ 'post' ] = $p;

                    $html .= self::generate_post_option( $newParam );

                }

            }

            return $html;

        }

    }