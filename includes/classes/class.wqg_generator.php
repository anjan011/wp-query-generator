<?php

    /**
     * Created by PhpStorm.
     * User: Anjan
     * Date: 9/15/15
     * Time: 11:56 AM
     */
    class wqg_generator {

        /**
         * The args itself
         *
         * @var array
         */

        private $_args = array ();

        /**
         * Input data
         *
         * @var array
         */

        private $_data = array ();

        function __construct ( $data = array () ) {

            $this->_data = $data;

        }


        /**
         * Gets generated args
         *
         * @return array
         */

        public function getGeneratedArgs () {

            return is_array ( $this->_args ) ? $this->_args : array ();

        }

        /**
         * Generates code
         *
         * @return string
         */

        public function generateCode () {

            $html = array ();

            $html[] = wqg_utils::_l ( 0, '<?php', 2 );

            $html[] = wqg_utils::_l ( 1, '// Query Args' );
            $html[] = wqg_utils::_l ( 1, '$args = array(', 2 );

            $args_code = $this->generateArgsCode ( 2 );

            if ( $args_code != '' ) {
                $html[] = $args_code;
            }
            else {
                $html[] = wqg_utils::_l ( 2, '// Params here ...', 2 );
            }


            $html[] = wqg_utils::_l ( 1, ');', 2 );

            $html[] = wqg_utils::_l ( 1, '// The Query' );
            $html[] = wqg_utils::_l ( 1, '$the_query = new WP_Query( $args );', 2 );

            $html[] = wqg_utils::_l ( 1, '// The Loop', 1 );
            $html[] = wqg_utils::_l ( 1, 'if ( $the_query->have_posts() ) {', 2 );

            $html[] = wqg_utils::_l ( 2, 'while ( $the_query->have_posts() ) {', 2 );
            $html[] = wqg_utils::_l ( 3, '$the_query->the_post();', 2 );
            $html[] = wqg_utils::_l ( 2, '}', 2 );

            $html[] = wqg_utils::_l ( 1, '} else {', 2 );
            $html[] = wqg_utils::_l ( 2, '// no posts found', 2 );
            $html[] = wqg_utils::_l ( 1, '}', 2 );

            $html[] = wqg_utils::_l ( 1, '// Restore original Post Data' );
            $html[] = wqg_utils::_l ( 1, 'wp_reset_postdata();', 2 );
            $html[] = wqg_utils::_l ( 0, '?>' );

            return join ( '', $html );

        }

        /**
         * Generates the WP_Query arguments code that will be passed to the query object
         *
         * @param int $start_indent
         *
         * @return string
         */

        public function generateArgsCode ( $start_indent = 0 ) {

            $code = array ();


            $code[] = $this->generateAuthorsArgCode ( $start_indent );
            $code[] = $this->generateCategoriesArgCode ( $start_indent );
            $code[] = $this->generateTagsArgCode ( $start_indent );
            $code[] = $this->generateTaxonomyArgCode ( $start_indent );
            $code[] = $this->generateSearchArgCode ( $start_indent );
            $code[] = $this->generatePageAndPostArgCode ( $start_indent );
            $code[] = $this->generateDateArgCode ( $start_indent );
            $code[] = $this->generateDateQueryArgCode ( $start_indent );

            $code[] = $this->generateSortingArgCode ( $start_indent );
            $code[] = $this->generatePaginationArgCode ( $start_indent );

            return join ( '', $code );

        }

        /**
         * Generate code and arguments for sorting
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateSortingArgCode ( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'sorting' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {


                // order

                $order = wqg_utils::array_value_as_string ( $data, 'order', '', 'trim' );


                if ( $order != '' ) {

                    $orderEsc = $wpdb->_escape ( $order );

                    $code[] = wqg_utils::_l ( $start_indent, "'order' => '{$orderEsc}',", 1 );

                    $this->_args[ 'order' ] = $order;
                }

                // orderby

                $orderby = wqg_utils::array_value_as_string ( $data, 'orderby', '', 'trim' );


                if ( $orderby != '' ) {

                    $orderbyEsc = $wpdb->_escape ( $orderby );

                    $code[] = wqg_utils::_l ( $start_indent, "'orderby' => '{$orderbyEsc}',", 1 );

                    $this->_args[ 'orderby' ] = $orderby;
                }

                // meta_key

                if ( $orderby == 'meta_value' || $orderby == 'meta_value_num' ) {

                    $meta_key = wqg_utils::array_value_as_string ( $data, 'meta_key', '', 'trim' );


                    if ( $meta_key != '' ) {

                        $meta_keyEsc = $wpdb->_escape ( $meta_key );

                        $code[] = wqg_utils::_l ( $start_indent, "'meta_key' => '{$meta_keyEsc}',", 1 );

                        $this->_args[ 'meta_key' ] = $meta_key;
                    }

                }


            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Sorting params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * generates codes and arguments related to pagination
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generatePaginationArgCode ( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'pagination' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {


                // nopaging

                $nopaging = wqg_utils::array_value_as_int ( $data, 'nopaging', 0 );

                $code[] = wqg_utils::_l ( $start_indent, "'nopaging' => " . ( $nopaging > 0 ? 'true' : 'false' ) . ",", 1 );

                $this->_args[ 'nopaging' ] = $nopaging > 0;


                if ( !$nopaging ) {

                    // posts_per_page

                    $posts_per_page = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'posts_per_page', '' ) );

                    if ( $posts_per_page != '' ) {

                        $posts_per_page = (int) $posts_per_page;

                        $code[] = wqg_utils::_l ( $start_indent, "'posts_per_page' => {$posts_per_page},", 1 );

                        $this->_args[ 'posts_per_page' ] = $posts_per_page;

                    }


                    // page

                    $page = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'page', '' ) );

                    if ( $page != '' ) {

                        $page = (int) $page;

                        $code[] = wqg_utils::_l ( $start_indent, "'page' => {$page},", 1 );

                        $this->_args[ 'page' ] = $page;

                    }

                    // paged

                    $paged = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'paged', '' ) );

                    if ( $paged != '' ) {

                        $paged = (int) $paged;

                        $code[] = wqg_utils::_l ( $start_indent, "'paged' => {$paged},", 1 );

                        $this->_args[ 'paged' ] = $paged;

                    }

                    // offset

                    $offset = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'offset', '' ) );

                    if ( $offset != '' ) {

                        $offset = (int) $offset;

                        if ( $offset >= 0 ) {

                            $code[] = wqg_utils::_l ( $start_indent, "'offset' => {$offset},", 1 );

                            $this->_args[ 'offset' ] = $offset;

                        }


                    }

                    // posts_per_archive_page

                    $posts_per_archive_page = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'posts_per_archive_page', '' ) );

                    if ( $posts_per_archive_page != '' ) {

                        $posts_per_archive_page = (int) $posts_per_archive_page;

                        $code[] = wqg_utils::_l ( $start_indent, "'posts_per_archive_page' => {$posts_per_archive_page},", 1 );

                        $this->_args[ 'posts_per_archive_page' ] = $posts_per_archive_page;

                    }

                    // ignore_sticky_posts

                    $ignore_sticky_posts = wqg_utils::array_value_as_int ( $data, 'ignore_sticky_posts', 0 );

                    $code[] = wqg_utils::_l ( $start_indent, "'ignore_sticky_posts' => " . ( $ignore_sticky_posts > 0 ? 'true' : 'false' ) . ",", 1 );

                    $this->_args[ 'ignore_sticky_posts' ] = $ignore_sticky_posts > 0;

                }


            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Pagination params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }


        /**
         * Generates code and arguments for author related params
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateAuthorsArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $author = wqg_utils::__ARRAY_VALUE ( $this->_data, 'author' );

            $code = array ();

            if ( is_array ( $author ) && count ( $author ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE ( $author, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'author' => {$id},", 1 );

                    $this->_args[ 'author' ] = $id;
                }

                // name

                $name = trim ( wqg_utils::__ARRAY_VALUE ( $author, 'name', '' ) );

                if ( $name != '' ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'author_name' => '{$name}',", 1 );

                    $this->_args[ 'author_name' ] = $name;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE ( $author, 'in' );

                if ( is_array ( $in ) && count ( $in ) > 0 ) {

                    $in = array_unique ( array_map ( 'intval', $in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'author__in' => array(" . join ( ", ", $in ) . "),", 1 );

                    $this->_args[ 'author__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE ( $author, 'not_in' );

                if ( is_array ( $not_in ) && count ( $not_in ) > 0 ) {

                    $not_in = array_unique ( array_map ( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'author__not_in' => array(" . join ( ", ", $not_in ) . "),", 1 );

                    $this->_args[ 'author__not_in' ] = $not_in;
                }

                if ( count ( $code ) > 0 ) {
                    $code[] = wqg_utils::_l ( 0, '', 1 );
                }

            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Authors params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * Generate code and arguments related to page and post
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generatePageAndPostArgCode ( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'post' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {


                // post_status

                $post_status = wqg_utils::array_value_as_array ( $data, 'post_status', array () );

                if ( is_array ( $post_status ) && count ( $post_status ) > 0 ) {

                    if ( in_array ( 'any', $post_status ) ) {
                        $post_status = array ( 'any' );
                    }
                    else {
                        $post_status = array_unique ( array_map ( 'trim', $post_status ) );
                    }

                    if ( count ( $post_status ) > 1 ) {
                        $code[] = wqg_utils::_l ( $start_indent, "'post_status' => array('" . join ( "', '", $post_status ) . "'),", 1 );
                    }
                    else {
                        $code[] = wqg_utils::_l ( $start_indent, "'post_status' => '{$post_status[0]}',", 1 );
                    }


                    $this->_args[ 'post_status' ] = $post_status;
                }

                // post_type

                $post_type = wqg_utils::array_value_as_array ( $data, 'post_type', array () );

                if ( is_array ( $post_type ) && count ( $post_type ) > 0 ) {

                    if ( in_array ( 'any', $post_type ) ) {
                        $post_type = array ( 'any' );
                    }
                    else {
                        $post_type = array_unique ( array_map ( 'trim', $post_type ) );
                    }

                    if ( count ( $post_type ) > 1 ) {
                        $code[] = wqg_utils::_l ( $start_indent, "'post_type' => array('" . join ( "', '", $post_type ) . "'),", 1 );
                    }
                    else {
                        $code[] = wqg_utils::_l ( $start_indent, "'post_type' => '{$post_type[0]}',", 1 );
                    }


                    $this->_args[ 'post_type' ] = $post_type;
                }

                // post_id

                $post_id = wqg_utils::array_value_as_array ( $data, 'post_id', array () );

                if ( count ( $post_id ) > 0 ) {

                    $post_id = array_map ( 'intval', $post_id );

                    if ( count ( $post_id ) > 1 ) {

                        $code[] = wqg_utils::_l ( $start_indent, "'post__in' => array(" . join ( ',', $post_id ) . "),", 1 );

                        $this->_args[ 'post__in' ] = $post_id;

                    }
                    else {

                        $code[] = wqg_utils::_l ( $start_indent, "'p' => {$post_id[0]},", 1 );

                        $this->_args[ 'p' ] = $post_id[ 0 ];

                    }

                }

                // post_slug

                $post_slug = wqg_utils::array_value_as_string ( $data, 'post_slug', '', 'trim' );


                if ( $post_slug != '' ) {

                    $post_slug = $wpdb->_escape ( $post_slug );

                    $code[] = wqg_utils::_l ( $start_indent, "'name' => '{$post_slug}',", 1 );

                    $this->_args[ 'name' ] = $post_slug;

                }

                // post_id_not_in

                $post_id_not_in = wqg_utils::array_value_as_array ( $data, 'post_id_not_in', array () );

                if ( is_array ( $post_id_not_in ) && !empty( $post_id_not_in ) ) {

                    $post_id_not_in = array_map ( 'intval', $post_id_not_in );

                    $code[] = wqg_utils::_l ( $start_indent, "'post__not_in' => array(" . join ( ',', $post_id_not_in ) . "),", 1 );

                    $this->_args[ 'post__not_in' ] = $post_id_not_in;

                }


                // post_parent

                $post_parent = wqg_utils::array_value_as_array ( $data, 'post_parent', array () );

                if ( is_array ( $post_parent ) && !empty( $post_parent ) ) {


                    $post_parent = array_map ( 'intval', $post_parent );

                    if ( count ( $post_parent ) > 1 ) {
                        $code[] = wqg_utils::_l ( $start_indent, "'post_parent__in' => array(" . join ( ',', $post_parent ) . "),", 1 );

                        $this->_args[ 'post_parent__in' ] = $post_parent;
                    }
                    else {

                        $code[] = wqg_utils::_l ( $start_indent, "'post_parent' => " . $post_parent[ 0 ] . ",", 1 );

                        $this->_args[ 'post_parent' ] = $post_parent[ 0 ];

                    }


                }

                // post_parent_not_in

                $post_parent_not_in = wqg_utils::array_value_as_array ( $data, 'post_parent_not_in', array () );

                if ( is_array ( $post_parent_not_in ) && !empty( $post_parent_not_in ) ) {


                    $post_parent_not_in = array_map ( 'intval', $post_parent_not_in );

                    $code[] = wqg_utils::_l ( $start_indent, "'post_parent__not_in' => array(" . join ( ',', $post_parent_not_in ) . "),", 1 );

                    $this->_args[ 'post_parent__not_in' ] = $post_parent_not_in;


                }


            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Post params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * Generates code and arguments related to categories
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateCategoriesArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'category' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE ( $data, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'cat' => {$id},", 1 );

                    $this->_args[ 'cat' ] = $id;
                }

                // name

                $name = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'name', '' ) );

                if ( $name != '' ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'cat_name' => '{$name}',", 1 );

                    $this->_args[ 'cat_name' ] = $name;
                }

                // and

                $and = wqg_utils::__ARRAY_VALUE ( $data, 'and' );

                if ( is_array ( $and ) && count ( $and ) > 0 ) {

                    $and = array_unique ( array_map ( 'intval', $and ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'category__and' => array(" . join ( ", ", $and ) . "),", 1 );

                    $this->_args[ 'category__and' ] = $and;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE ( $data, 'in' );

                if ( is_array ( $in ) && count ( $in ) > 0 ) {

                    $in = array_unique ( array_map ( 'intval', $in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'category__in' => array(" . join ( ", ", $in ) . "),", 1 );

                    $this->_args[ 'category__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE ( $data, 'not_in' );

                if ( is_array ( $not_in ) && count ( $not_in ) > 0 ) {

                    $not_in = array_unique ( array_map ( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'category__not_in' => array(" . join ( ", ", $not_in ) . "),", 1 );

                    $this->_args[ 'category__not_in' ] = $not_in;
                }

                if ( count ( $code ) > 0 ) {
                    $code[] = wqg_utils::_l ( 0, '', 1 );
                }

            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Categories params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * Generate code and arguments related to tags
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateTagsArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'tag' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE ( $data, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'tag_id' => {$id},", 1 );

                    $this->_args[ 'tag_id' ] = $id;
                }

                // slug

                $slug = trim ( wqg_utils::__ARRAY_VALUE ( $data, 'slug', '' ) );

                if ( $slug != '' ) {
                    $code[] = wqg_utils::_l ( $start_indent, "'tag' => '{$slug}',", 1 );

                    $this->_args[ 'tag' ] = $slug;
                }

                // slug and

                $slug_and = wqg_utils::__ARRAY_VALUE ( $data, 'slug_and' );

                if ( is_array ( $slug_and ) && count ( $slug_and ) > 0 ) {

                    $slug_and = array_unique ( array_map ( 'trim', $slug_and ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'tag__slug_and' => array('" . join ( "', '", $slug_and ) . "'),", 1 );

                    $this->_args[ 'tag__slug_and' ] = $slug_and;
                }

                // slug in

                $slug_in = wqg_utils::__ARRAY_VALUE ( $data, 'slug_in' );

                if ( is_array ( $slug_in ) && count ( $slug_in ) > 0 ) {

                    $slug_in = array_unique ( array_map ( 'trim', $slug_in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'tag__slug_in' => array('" . join ( "', '", $slug_in ) . "'),", 1 );

                    $this->_args[ 'tag__slug_in' ] = $slug_in;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE ( $data, 'in' );

                if ( is_array ( $in ) && count ( $in ) > 0 ) {

                    $in = array_unique ( array_map ( 'intval', $in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'tag__in' => array(" . join ( ", ", $in ) . "),", 1 );

                    $this->_args[ 'tag__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE ( $data, 'not_in' );

                if ( is_array ( $not_in ) && count ( $not_in ) > 0 ) {

                    $not_in = array_unique ( array_map ( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'tag__not_in' => array(" . join ( ", ", $not_in ) . "),", 1 );

                    $this->_args[ 'tag__not_in' ] = $not_in;
                }

                // not in

                $and = wqg_utils::__ARRAY_VALUE ( $data, 'and' );

                if ( is_array ( $and ) && count ( $and ) > 0 ) {

                    $and = array_unique ( array_map ( 'intval', $and ) );

                    $code[] = wqg_utils::_l ( $start_indent, "'tag__and' => array(" . join ( ", ", $and ) . "),", 1 );

                    $this->_args[ 'tag__and' ] = $and;
                }

                if ( count ( $code ) > 0 ) {
                    $code[] = wqg_utils::_l ( 0, '', 1 );
                }

            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Tags params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * Generates taxonomy related code and arguments
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateTaxonomyArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'tax' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                /**
                 * Taxonomy Data
                 */

                $relation = wqg_utils::__ARRAY_VALUE ( $data, 'relation', 'AND' );
                $rules = wqg_utils::array_value_as_array ( $data, 'rules', array () );

                $non_empty_rules_count = 0;

                if ( is_array ( $rules ) && count ( $rules ) > 0 ) {

                    foreach ( $rules as $r ) {
                        $term = wqg_utils::array_value_as_array ( $r, 'term', array () );

                        if ( !empty( $term ) ) {
                            $non_empty_rules_count += 1;
                        }
                    }
                }


                if ( count ( $rules ) > 0 ) {


                    $this->_args[ 'tax_query' ] = array ();

                    $code[] = wqg_utils::_l ( $start_indent, "'tax_query' => array(", 1 );

                    // relation


                    if ( $non_empty_rules_count > 1 ) {
                        $code[] = wqg_utils::_l ( $start_indent + 1, "'relation' => '{$relation}',", 1 );

                        $this->_args[ 'tax_query' ][ 'relation' ] = $relation;
                    }

                    // rules

                    if ( count ( $rules ) > 0 ) {

                        foreach ( $rules as $r ) {

                            $name = wqg_utils::array_value_as_string ( $r, 'name', '', 'trim' );
                            $field = wqg_utils::array_value_as_string ( $r, 'field', '', 'trim' );
                            $operator = wqg_utils::array_value_as_string ( $r, 'operator', '', 'trim' );
                            $term = wqg_utils::array_value_as_array ( $r, 'term', array () );
                            $include_children = wqg_utils::array_value_as_int ( $r, 'include_children', 0 );

                            if ( empty( $term ) ) {
                                continue;
                            }

                            $code[] = wqg_utils::_l ( $start_indent + 1, "array(", 1 );

                            $code[] = wqg_utils::_l ( $start_indent + 2, "'taxonomy' => '{$name}',", 1 );
                            $code[] = wqg_utils::_l ( $start_indent + 2, "'field' => '{$field}',", 1 );

                            $code[] = wqg_utils::_l ( $start_indent + 2, "'terms' => array(", 1 );

                            foreach ( $term as $t ) {

                                $t = trim ( $t );

                                $code[] = wqg_utils::_l ( $start_indent + 3, "'{$t}'", 1 );
                            }

                            $code[] = wqg_utils::_l ( $start_indent + 2, "),", 1 );

                            $code[] = wqg_utils::_l ( $start_indent + 2, "'operator' => '{$operator}',", 1 );
                            $code[] = wqg_utils::_l ( $start_indent + 2, "'include_children' => " . ( $include_children > 0 ? 'true' : 'false' ) . ",", 1 );

                            $code[] = wqg_utils::_l ( $start_indent + 1, "),", 1 );

                            $this->_args[ 'tax_query' ][] = array (
                                'taxonomy'         => $name,
                                'field'            => $field,
                                'terms'            => $term,
                                'operator'         => $operator,
                                'include_children' => $include_children > 0,
                            );

                        }

                    }

                    $code[] = wqg_utils::_l ( $start_indent, "),", 1 );


                }


            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Taxonomy params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );

        }

        /**
         * Generates search code and arguments
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateSearchArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'search' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                /**
                 * Keyword
                 */

                $keyword = wqg_utils::__ARRAY_VALUE ( $data, 'keyword', '' );

                if ( $keyword != '' ) {

                    $this->_args[ 's' ] = $keyword;

                    $code[] = wqg_utils::_l ( $start_indent, "'s' => '" . ( $keyword ) . "'", 1 );

                }

            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Search params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );


        }

        /**
         * Generates date related code and args
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateDateArgCode ( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'date' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                /**
                 * year
                 */

                $year = wqg_utils::__ARRAY_VALUE ( $data, 'year', '' );

                if ( $year != '' ) {

                    $year = (int) $year;

                    if ( $year > 0 ) {

                        $this->_args[ 'year' ] = $year;

                        $code[] = wqg_utils::_l ( $start_indent, "'year' => " . ( $year ) . ",", 1 );
                    }

                }

                /**
                 * monthnum
                 */

                $monthnum = wqg_utils::__ARRAY_VALUE ( $data, 'monthnum', '' );

                if ( $monthnum != '' ) {

                    $monthnum = (int) $monthnum;

                    if ( $monthnum >= 1 && $monthnum <= 12 ) {

                        $this->_args[ 'monthnum' ] = $monthnum;

                        $code[] = wqg_utils::_l ( $start_indent, "'monthnum' => " . ( $monthnum ) . ",", 1 );
                    }

                }

                /**
                 * week
                 */

                $week = wqg_utils::__ARRAY_VALUE ( $data, 'week', '' );

                if ( $week != '' ) {

                    $week = (int) $week;

                    if ( $week >= 0 && $week <= 53 ) {

                        $this->_args[ 'w' ] = $week;

                        $code[] = wqg_utils::_l ( $start_indent, "'w' => " . ( $week ) . ",", 1 );
                    }

                }

                /**
                 * day
                 */

                $day = wqg_utils::__ARRAY_VALUE ( $data, 'day', '' );

                if ( $day != '' ) {

                    $day = (int) $day;

                    if ( $day >= 1 && $day <= 31 ) {

                        $this->_args[ 'day' ] = $day;

                        $code[] = wqg_utils::_l ( $start_indent, "'day' => " . ( $day ) . ",", 1 );
                    }

                }

                /**
                 * hour
                 */

                $hour = wqg_utils::__ARRAY_VALUE ( $data, 'hour', '' );

                if ( $hour != '' ) {

                    $hour = (int) $hour;

                    if ( $hour >= 0 && $hour <= 23 ) {

                        $this->_args[ 'hour' ] = $hour;

                        $code[] = wqg_utils::_l ( $start_indent, "'hour' => " . ( $hour ) . ",", 1 );
                    }

                }

                /**
                 * minute
                 */

                $minute = wqg_utils::__ARRAY_VALUE ( $data, 'minute', '' );

                if ( $minute != '' ) {

                    $minute = (int) $minute;

                    if ( $minute >= 0 && $minute <= 59 ) {

                        $this->_args[ 'minute' ] = $minute;

                        $code[] = wqg_utils::_l ( $start_indent, "'minute' => " . ( $minute ) . ",", 1 );
                    }

                }

                /**
                 * seconds
                 */

                $second = wqg_utils::__ARRAY_VALUE ( $data, 'second', '' );

                if ( $second != '' ) {

                    $second = (int) $second;

                    if ( $second >= 0 && $second <= 59 ) {

                        $this->_args[ 'second' ] = $second;

                        $code[] = wqg_utils::_l ( $start_indent, "'second' => " . ( $second ) . ",", 1 );
                    }

                }

            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Date params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );


        }

        /**
         * Generates code and args related to date query. Its kinda complex, so i
         * decided to put it inside a separate function instead of mixing it with
         * simple date params handler function.
         *
         * @param $start_indent
         *
         * @return string
         */

        public function generateDateQueryArgCode ( $start_indent ) {

            /** @var wpdb $wpdb */

            global $wpdb;


            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE ( $this->_data, 'date_query' );

            $code = array ();

            if ( is_array ( $data ) && count ( $data ) > 0 ) {

                $relation = strtolower(wqg_utils::array_value_as_string($data,'relation','and','trim'));

                $relationEsc = $wpdb->_escape($relation);

                $criteria = wqg_utils::array_value_as_array($data,'criteria',array());

                if(count($criteria) > 0) {

                    $dateCompareOperators = array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );

                    $dateColumns = array('post_date','post_modified','post_date_gmt','post_modified_gmt');

                    $subArrays = array();

                    foreach($criteria as $dq) {



                        $hasValue = false;

                        $temp = array();

                        /* column */

                        $column = strtoupper(wqg_utils::array_value_as_string($dq,'column','post_date','trim'));

                        if(!in_array($column,$dateColumns)) {
                            $column = 'post_date';
                        }

                        $temp['column'] = $wpdb->_escape($column);

                        /* Compare */

                        $compare = strtoupper(wqg_utils::array_value_as_string($dq,'compare','=','trim'));

                        if(!in_array($compare,$dateCompareOperators)) {
                            $compare = '=';
                        }

                        $temp['compare'] = $wpdb->_escape($compare);

                        /**
                         * year
                         */

                        $year = wqg_utils::array_value_as_string($dq, 'year', '','trim');

                        if ( $year != '' ) {

                            $year = (int) $year;

                            if ( $year > 0 ) {

                                $temp['year'] = $year;

                                $hasValue = true;
                            }

                        }

                        /**
                         * month
                         */

                        $month = wqg_utils::array_value_as_string($dq, 'month', '','trim');

                        if ( $month != '' ) {

                            $month = (int) $month;

                            if ( $month >= 1 && $month <= 12 ) {

                                $temp['month'] = $month;

                                $hasValue = true;
                            }

                        }

                        /**
                         * week
                         */

                        $week = wqg_utils::array_value_as_string($dq, 'week', '','trim');

                        if ( $week != '' ) {

                            $week = (int) $week;

                            if ( $week >= 0 && $week <= 53 ) {

                                $temp['week'] = $week;

                                $hasValue = true;
                            }

                        }

                        /**
                         * day
                         */

                        $day = wqg_utils::array_value_as_string($dq, 'day', '','trim');

                        if ( $day != '' ) {

                            $day = (int) $day;

                            if ( $day >= 1 && $day <= 31 ) {

                                $temp['day'] = $day;

                                $hasValue = true;
                            }

                        }

                        /**
                         * hour
                         */

                        $hour = wqg_utils::array_value_as_string($dq, 'hour', '','trim');

                        if ( $hour != '' ) {

                            $hour = (int) $hour;

                            if ( $hour >= 0 && $hour <= 59 ) {

                                $temp['hour'] = $hour;

                                $hasValue = true;
                            }

                        }

                        /**
                         * minute
                         */

                        $minute = wqg_utils::array_value_as_string($dq, 'minute', '','trim');

                        if ( $minute != '' ) {

                            $minute = (int) $minute;

                            if ( $minute >= 0 && $minute <= 59 ) {

                                $temp['minute'] = $minute;

                                $hasValue = true;
                            }

                        }

                        /**
                         * second
                         */

                        $second = wqg_utils::array_value_as_string($dq, 'second', '','trim');

                        if ( $second != '' ) {

                            $second = (int) $second;

                            if ( $second >= 0 && $second <= 59 ) {

                                $temp['second'] = $second;

                                $hasValue = true;
                            }

                        }

                        if($hasValue) {
                            $subArrays[] = $temp;
                        }

                    }

                    if(count($subArrays) > 0) {

                        $code[] = wqg_utils::_l ( $start_indent, "'date_query' => array(", 2 );

                        if(count($subArrays) > 1) {

                            $code[] = wqg_utils::_l ( $start_indent + 1, "'relation' => '{$relationEsc}'", 2 );

                            $this->_args['date_query']['relation'] = $relation;

                        }

                        foreach($subArrays as $c) {

                            $code[] = wqg_utils::_l ( $start_indent + 1, "array(", 2 );

                            foreach($c as $k => $v) {

                                if($k == 'compare' || $k == 'column') {
                                    $code[] = wqg_utils::_l ( $start_indent + 2, "'{$k}' => '{$v}',", 1 );
                                } else {
                                    $code[] = wqg_utils::_l ( $start_indent + 2, "'{$k}' => {$v},", 1 );
                                }


                            }

                            $code[] = wqg_utils::_l ( $start_indent + 1, "),", 2 );

                            $this->_args['date_query'][] = $c;

                        }

                        $code[] = wqg_utils::_l ( $start_indent, "),", 2 );

                    }

                }





            }

            if ( !empty( $code ) ) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l ( $start_indent, "/* Date query params */", 2 );

                $content .= join ( '', $code );

                return $content;

            }

            return join ( '', $code );


        }

    }