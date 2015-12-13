<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 11/8/15
     * Time: 9:36 PM
     */
    class meAnjanWqg_Posts {

        /**
         * Get posts
         *
         * @param array $params
         *
         * @return array
         */

        public static function getPosts( $params = array() ) {

            $params = is_array( $params ) ? $params : array();

            $params[ 'post_type' ] = meAnjanWqg_Utils::arrayValueAsArray( $params, 'post_type', array( 'post' ) );
            $params[ 'order' ] = meAnjanWqg_Utils::arrayValueAsString( $params, 'order', 'asc', 'trim' );
            $params[ 'orderby' ] = meAnjanWqg_Utils::arrayValueAsString( $params, 'orderby', 'title', 'trim' );
            $params[ 'nopaging' ] = meAnjanWqg_Utils::arrayValue( $params, 'nopaging', TRUE );
            $params[ 'post_parent' ] = meAnjanWqg_Utils::arrayValueAsInt( $params, 'post_parent', 0 );

            $q = new WP_Query( $params );

            $posts = $q->get_posts();

            $q->reset_postdata();

            return $posts;

        }

        /**
         * Get post id, title and slug grouped by post type
         *
         * @param array $posts
         * @param array $params
         */

        public static function getPostsMinimal( &$posts = array(), $params = array()) {

            $post_types = meAnjanWqg_Utils::arrayValueAsArray( $params, 'post_type', array( 'post' ) );

            foreach($post_types as $ptype) {

                if(!isset($posts[$ptype])) {
                    $posts[$ptype] = array();
                }

                $newParams = $params;

                $newParams['post_type'] = array($ptype);

                $foundPosts = self::getPosts($newParams);

                if(!is_array($foundPosts) || count($foundPosts) == 0) {
                    $posts[$ptype] = array();
                } else {

                    foreach($foundPosts as $fp) {

                        $posts[$ptype][] = array(
                            'id' => $fp->ID,
                            'title' => $fp->post_title,
                            'slug' => $fp->post_name,
                        );

                    }

                }

            }

        }

        /**
         * generates posts list dropdown
         *
         * @param array $params
         *
         * @return string
         */

        public static function postsDropdown( $params = array() ) {

            $params[ 'post_type' ] = meAnjanWqg_Utils::arrayValueAsArray( $params, 'post_type', array( 'post' ) );

            if ( in_array( 'any', $params[ 'post_type' ] ) ) {
                $params[ 'post_type' ] = array( 'any' );
            }

            $attributes = meAnjanWqg_Utils::arrayValue( $params, 'attributes', array() );

            $selected = meAnjanWqg_Utils::arrayValue( $params, 'selected', '' );

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

            $empty_value = meAnjanWqg_Utils::arrayValue( $params, 'empty_value', FALSE );

            if ( is_array( $empty_value ) && isset($empty_value[ 'label' ]) && isset($empty_value[ 'value' ]) ) {

                $html .= "<option value='{$empty_value['value']}'>{$empty_value['label']}</option>";

            }

            foreach ( $params[ 'post_type' ] as $post_type ) {

                $html .= '<optgroup label="'.$post_type.'">';

                $params[ 'post_type' ] = array( $post_type );

                $posts = self::getPosts( $params );

                if ( is_array( $posts ) && count( $posts ) > 0 ) {

                    foreach ( $posts as $p ) {

                        $html .= self::generatePostOption( array(
                            'post_type'   => array( $post_type ),
                            'post'        => $p,
                            'selected'    => $selected,
                            'label_field' => meAnjanWqg_Utils::arrayValue( $params, 'label_field', 'post_title' ),
                            'label_field_extra' => meAnjanWqg_Utils::arrayValue( $params, 'label_field_extra', '' ),
                            'value_field' => meAnjanWqg_Utils::arrayValue( $params, 'value_field', 'ID' ),
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

        public static function generatePostOption( $params = array() ) {

            $post = meAnjanWqg_Utils::arrayValue( $params, 'post', FALSE );

            if ( !is_object( $post ) || !($post instanceof WP_Post) ) {
                return FALSE;
            }


            $label_field = meAnjanWqg_Utils::arrayValue( $params, 'label_field', 'post_title' );
            $label_field_extra = meAnjanWqg_Utils::arrayValue( $params, 'label_field_extra', '' );
            $value_field = meAnjanWqg_Utils::arrayValue( $params, 'value_field', 'ID' );

            $indent = (int) meAnjanWqg_Utils::arrayValue( $params, 'indent', 0 );

            $label = isset($post->$label_field) ? $post->$label_field : '';
            $value = isset($post->$value_field) ? $post->$value_field : '';

            $label_extra = '';

            if($label_field_extra  != '') {
                $label_extra = isset($post->$label_field_extra) ? $post->$label_field_extra : '';
            }

            $label = str_repeat( '-', $indent ).$label;

            /* Selected attr */

            $selected_attr = '';

            $selected = meAnjanWqg_Utils::arrayValue( $params, 'selected', '' );

            if ( is_array( $selected ) && in_array( $value, $selected ) ) {
                $selected_attr = ' selected';
            }
            else if ( $selected == $value ) {
                $selected_attr = ' selected';
            }

            $html = "<option value='{$value}'{$selected_attr}>{$label}".(!empty($label_extra) ? " [{$label_extra}]":'')."</option>";

            $params[ 'post_parent' ] = $post->ID;

            $child_posts = self::getPosts( $params );

            /* Child categories */

            if ( is_array( $child_posts ) && count( $child_posts ) > 0 ) {

                foreach ( $child_posts as $p ) {

                    $newParam = $params;

                    $newParam[ 'indent' ] = $indent + 1;

                    $newParam[ 'post' ] = $p;

                    $html .= self::generatePostOption( $newParam );

                }

            }

            return $html;

        }

        /**
         * Gets post order by field values
         *
         * @return array
         */

        public static function getPostOrderByFields() {

            $keys = array(

                'ID',
                'author',
                'title',
                'name',
                'date',
                'modified',
                'parent',
                'rand',
                'menu_order',
                'meta_value',

            );

            if(meAnjanWqg_Utils::isMinWpVersion('2.8')) {
                $keys[] = 'none';
                $keys[] = 'meta_value_num';
            }

            if(meAnjanWqg_Utils::isMinWpVersion('2.9')) {
                $keys[] = 'comment_count';
            }

            if(meAnjanWqg_Utils::isMinWpVersion('3.5')) {
                $keys[] = 'post__in';
            }

            if(meAnjanWqg_Utils::isMinWpVersion('4.0')) {
                $keys[] = 'type';
            }

            asort($keys);

            return $keys;


        }

        /**
         * Get all post meta keys
         *
         * @return array
         */

        public static function getAllPostMetaKeys() {

            /** @var wpdb $wpdb */

            global $wpdb;

            $sql = "select distinct pm.meta_key from wp_postmeta pm order by pm.meta_key";

            return $wpdb->get_col($sql,0);

        }

    }

