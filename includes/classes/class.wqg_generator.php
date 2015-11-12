<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/15/15
     * Time: 11:56 AM
     */
    class wqg_generator {

        /**
         * The args itself
         *
         * @var array
         */

        private $_args = array();

        /**
         * Input data
         *
         * @var array
         */

        private $_data = array();

        function __construct( $data = array() ) {

            $this->_data = $data;//$this->prepare_data( $data );

        }

        public function getGeneratedArgs() {

            return $this->_args;

        }


        /**
         * Prepare data so it conforms to expected form
         *
         * @param $data
         *
         * @return array
         */

        public function prepare_data( $data ) {

            $data = is_array( $data ) ? $data : array();

            // author

            $data[ 'author' ] = wqg_utils::__ARRAY_VALUE( $data, 'author', array() );

            $data[ 'author' ][ 'id' ] = trim( wqg_utils::__ARRAY_VALUE( $data, 'author/id', '' ) );
            $data[ 'author' ][ 'name' ] = trim( wqg_utils::__ARRAY_VALUE( $data, 'author/name', '' ) );
            $data[ 'author' ][ 'in' ] = wqg_utils::__ARRAY_VALUE( $data, 'author/in' );
            $data[ 'author' ][ 'not_in' ] = wqg_utils::__ARRAY_VALUE( $data, 'author/not_in' );

            return $data;
        }

        /**
         * generates code
         *
         * @return string
         */

        public function generate_code() {

            $data = $this->_data;

            $html = array();

            $html[] = wqg_utils::_l( 0, '<?php', 2 );

            $html[] = wqg_utils::_l( 1, '// Query Args' );
            $html[] = wqg_utils::_l( 1, '$args = array(', 2 );

            $args_code = $this->generate_args_code( 2 );

            if ( $args_code != '' ) {
                $html[] = $args_code;
            }
            else {
                $html[] = wqg_utils::_l( 2, '// Params here ...', 2 );
            }


            $html[] = wqg_utils::_l( 1, ');', 2 );

            $html[] = wqg_utils::_l( 1, '// The Query' );
            $html[] = wqg_utils::_l( 1, '$the_query = new WP_Query( $args );', 2 );

            $html[] = wqg_utils::_l( 1, '// The Loop', 1 );
            $html[] = wqg_utils::_l( 1, 'if ( $the_query->have_posts() ) {', 2 );

            $html[] = wqg_utils::_l( 2, 'while ( $the_query->have_posts() ) {', 2 );
            $html[] = wqg_utils::_l( 3, '$the_query->the_post();', 2 );
            $html[] = wqg_utils::_l( 2, '}', 2 );

            $html[] = wqg_utils::_l( 1, '} else {', 2 );
            $html[] = wqg_utils::_l( 2, '// no posts found', 2 );
            $html[] = wqg_utils::_l( 1, '}', 2 );

            $html[] = wqg_utils::_l( 1, '// Restore original Post Data' );
            $html[] = wqg_utils::_l( 1, 'wp_reset_postdata();', 2 );
            $html[] = wqg_utils::_l( 0, '?>' );

            return join( '', $html );

        }

        public function generate_args_code( $start_indent = 0 ) {

            $code = array();


            $code[] = $this->generate_authors_arg_code( $start_indent );
            $code[] = $this->generate_categories_arg_code( $start_indent );
            $code[] = $this->generate_tags_arg_code( $start_indent );
            $code[] = $this->generate_taxonomy_arg_code( $start_indent );
            $code[] = $this->generate_search_arg_code( $start_indent );
            $code[] = $this->generate_page_and_post_arg_code($start_indent);
            $code[] = $this->generate_pagination_arg_code($start_indent);
            $code[] = $this->generate_sorting_arg_code($start_indent);

            return join( '', $code );

        }

        public function generate_sorting_arg_code( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'sorting' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {


                // order

                $order = wqg_utils::array_value_as_string($data,'order','','trim');


                if($order != '') {

                    $orderEsc = $wpdb->_escape($order);

                    $code[] = wqg_utils::_l( $start_indent, "'order' => '{$orderEsc}',", 1 );

                    $this->_args['order'] = $order;
                }

                // orderby

                $orderby = wqg_utils::array_value_as_string($data,'orderby','','trim');


                if($orderby != '') {

                    $orderbyEsc = $wpdb->_escape($orderby);

                    $code[] = wqg_utils::_l( $start_indent, "'orderby' => '{$orderbyEsc}',", 1 );

                    $this->_args['orderby'] = $orderbyEsc;
                }








            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Sorting params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_pagination_arg_code( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'pagination' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {


                // nopaging

                $nopaging = wqg_utils::array_value_as_int($data,'nopaging',0);

                $code[] = wqg_utils::_l( $start_indent, "'nopaging' => ".($nopaging > 0 ? 'true':'false').",", 1 );

                $this->_args['nopaging'] = $nopaging > 0;


                if(!$nopaging) {

                    // posts_per_page

                    $posts_per_page =  trim(wqg_utils::__ARRAY_VALUE($data,'posts_per_page',''));

                    if($posts_per_page != '') {

                        $posts_per_page = (int)$posts_per_page;

                        $code[] = wqg_utils::_l( $start_indent, "'posts_per_page' => {$posts_per_page},", 1 );

                        $this->_args['posts_per_page'] = $posts_per_page;

                    }



                    // page

                    $page =  trim(wqg_utils::__ARRAY_VALUE($data,'page',''));

                    if($page != '') {

                        $page = (int)$page;

                        $code[] = wqg_utils::_l( $start_indent, "'page' => {$page},", 1 );

                        $this->_args['page'] = $page;

                    }

                    // paged

                    $paged =  trim(wqg_utils::__ARRAY_VALUE($data,'paged',''));

                    if($paged != '') {

                        $paged =  (int)$paged;

                        $code[] = wqg_utils::_l( $start_indent, "'paged' => {$paged},", 1 );

                        $this->_args['paged'] = $paged;

                    }

                    // offset

                    $offset =  trim(wqg_utils::__ARRAY_VALUE($data,'offset',''));

                    if($offset != '') {

                        $offset =  (int)$offset;

                        if($offset >= 0) {

                            $code[] = wqg_utils::_l( $start_indent, "'offset' => {$offset},", 1 );

                            $this->_args['offset'] = $offset;

                        }



                    }

                    // posts_per_archive_page

                    $posts_per_archive_page =  trim(wqg_utils::__ARRAY_VALUE($data,'posts_per_archive_page',''));

                    if($posts_per_archive_page != '') {

                        $posts_per_archive_page = (int)$posts_per_archive_page;

                        $code[] = wqg_utils::_l( $start_indent, "'posts_per_archive_page' => {$posts_per_archive_page},", 1 );

                        $this->_args['posts_per_archive_page'] = $posts_per_archive_page;

                    }

                    // ignore_sticky_posts

                    $ignore_sticky_posts = wqg_utils::array_value_as_int($data,'ignore_sticky_posts',0);

                    $code[] = wqg_utils::_l( $start_indent, "'ignore_sticky_posts' => ".($ignore_sticky_posts > 0 ? 'true':'false').",", 1 );

                    $this->_args['ignore_sticky_posts'] = $ignore_sticky_posts > 0;

                }



            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Pagination params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_authors_arg_code( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $author = wqg_utils::__ARRAY_VALUE( $this->_data, 'author' );

            $code = array();

            if ( is_array( $author ) && count( $author ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE( $author, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l( $start_indent, "'author' => {$id},", 1 );

                    $this->_args[ 'author' ] = $id;
                }

                // name

                $name = trim( wqg_utils::__ARRAY_VALUE( $author, 'name', '' ) );

                if ( $name != '' ) {
                    $code[] = wqg_utils::_l( $start_indent, "'author_name' => '{$name}',", 1 );

                    $this->_args[ 'author_name' ] = $name;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE( $author, 'in' );

                if ( is_array( $in ) && count( $in ) > 0 ) {

                    $in = array_unique( array_map( 'intval', $in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'author__in' => array(".join( ", ", $in )."),", 1 );

                    $this->_args[ 'author__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE( $author, 'not_in' );

                if ( is_array( $not_in ) && count( $not_in ) > 0 ) {

                    $not_in = array_unique( array_map( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'author__not_in' => array(".join( ", ", $not_in )."),", 1 );

                    $this->_args[ 'author__not_in' ] = $not_in;
                }

                if ( count( $code ) > 0 ) {
                    $code[] = wqg_utils::_l( 0, '', 1 );
                }

            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Authors params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_page_and_post_arg_code( $start_indent ) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'post' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {


                // post_status

                $post_status = wqg_utils::array_value_as_array($data,'post_status',array());

                if ( is_array( $post_status ) && count( $post_status ) > 0 ) {

                    if(in_array('any',$post_status)) {
                        $post_status = array('any');
                    } else {
                        $post_status = array_unique( array_map( 'trim', $post_status ) );
                    }

                    if(count($post_status) > 1) {
                        $code[] = wqg_utils::_l( $start_indent, "'post_status' => array('".join( "', '", $post_status )."'),", 1 );
                    } else {
                        $code[] = wqg_utils::_l( $start_indent, "'post_status' => '{$post_status[0]}',", 1 );
                    }



                    $this->_args[ 'post_status' ] = $post_status;
                }

                // post_type

                $post_type = wqg_utils::array_value_as_array($data,'post_type',array());

                if ( is_array( $post_type ) && count( $post_type ) > 0 ) {

                    if(in_array('any',$post_type)) {
                        $post_type = array('any');
                    } else {
                        $post_type = array_unique( array_map( 'trim', $post_type ) );
                    }

                    if(count($post_type) > 1) {
                        $code[] = wqg_utils::_l( $start_indent, "'post_type' => array('".join( "', '", $post_type )."'),", 1 );
                    } else {
                        $code[] = wqg_utils::_l( $start_indent, "'post_type' => '{$post_type[0]}',", 1 );
                    }



                    $this->_args[ 'post_type' ] = $post_type;
                }

                // post_id

                $post_id = wqg_utils::array_value_as_array( $data, 'post_id', array() );

                if(count($post_id) > 0) {

                    $post_id = array_map('intval',$post_id);

                    if(count($post_id) > 1) {

                        $code[] = wqg_utils::_l( $start_indent, "'post__in' => array(".join(',',$post_id)."),", 1 );

                        $this->_args[ 'post__in' ] = $post_id;

                    } else {

                        $code[] = wqg_utils::_l( $start_indent, "'p' => {$post_id[0]},", 1 );

                        $this->_args[ 'p' ] = $post_id[0];

                    }

                }

                // post_slug

                $post_slug = wqg_utils::array_value_as_string($data,'post_slug','','trim');


                if($post_slug != '') {

                    $post_slug = $wpdb->_escape($post_slug);

                    $code[] = wqg_utils::_l( $start_indent, "'name' => '{$post_slug}',", 1 );

                    $this->_args[ 'name' ] = $post_slug;

                }

                // post_id_not_in

                $post_id_not_in = wqg_utils::array_value_as_array($data,'post_id_not_in',array());

                if(is_array($post_id_not_in) && !empty($post_id_not_in)) {

                    $post_id_not_in = array_map('intval',$post_id_not_in);

                    $code[] = wqg_utils::_l( $start_indent, "'post__not_in' => array(".join(',',$post_id_not_in)."),", 1 );

                    $this->_args[ 'post__not_in' ] = $post_id_not_in;

                }


                // post_parent

                $post_parent = wqg_utils::array_value_as_array($data,'post_parent',array());

                if(is_array($post_parent) && !empty($post_parent)) {



                    $post_parent = array_map('intval',$post_parent);

                    if(count($post_parent) > 1) {
                        $code[] = wqg_utils::_l( $start_indent, "'post_parent__in' => array(".join(',',$post_parent)."),", 1 );

                        $this->_args[ 'post_parent__in' ] = $post_parent;
                    } else {

                        $code[] = wqg_utils::_l( $start_indent, "'post_parent' => ".$post_parent[0].",", 1 );

                        $this->_args[ 'post_parent' ] = $post_parent[0];

                    }



                }

                // post_parent_not_in

                $post_parent_not_in = wqg_utils::array_value_as_array($data,'post_parent_not_in',array());

                if(is_array($post_parent_not_in) && !empty($post_parent_not_in)) {



                    $post_parent_not_in = array_map('intval',$post_parent_not_in);

                    $code[] = wqg_utils::_l( $start_indent, "'post_parent__not_in' => array(".join(',',$post_parent_not_in)."),", 1 );

                    $this->_args[ 'post_parent__not_in' ] = $post_parent_not_in;



                }



            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Post params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_categories_arg_code( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'category' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE( $data, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l( $start_indent, "'cat' => {$id},", 1 );

                    $this->_args[ 'cat' ] = $id;
                }

                // name

                $name = trim( wqg_utils::__ARRAY_VALUE( $data, 'name', '' ) );

                if ( $name != '' ) {
                    $code[] = wqg_utils::_l( $start_indent, "'cat_name' => '{$name}',", 1 );

                    $this->_args[ 'cat_name' ] = $name;
                }

                // and

                $and = wqg_utils::__ARRAY_VALUE( $data, 'and' );

                if ( is_array( $and ) && count( $and ) > 0 ) {

                    $and = array_unique( array_map( 'intval', $and ) );

                    $code[] = wqg_utils::_l( $start_indent, "'category__and' => array(".join( ", ", $and )."),", 1 );

                    $this->_args[ 'category__and' ] = $and;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE( $data, 'in' );

                if ( is_array( $in ) && count( $in ) > 0 ) {

                    $in = array_unique( array_map( 'intval', $in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'category__in' => array(".join( ", ", $in )."),", 1 );

                    $this->_args[ 'category__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE( $data, 'not_in' );

                if ( is_array( $not_in ) && count( $not_in ) > 0 ) {

                    $not_in = array_unique( array_map( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'category__not_in' => array(".join( ", ", $not_in )."),", 1 );

                    $this->_args[ 'category__not_in' ] = $not_in;
                }

                if ( count( $code ) > 0 ) {
                    $code[] = wqg_utils::_l( 0, '', 1 );
                }

            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Categories params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_tags_arg_code( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'tag' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {

                // id

                $id = (int) wqg_utils::__ARRAY_VALUE( $data, 'id', 0 );

                if ( $id > 0 ) {
                    $code[] = wqg_utils::_l( $start_indent, "'tag_id' => {$id},", 1 );

                    $this->_args[ 'tag_id' ] = $id;
                }

                // slug

                $slug = trim( wqg_utils::__ARRAY_VALUE( $data, 'slug', '' ) );

                if ( $slug != '' ) {
                    $code[] = wqg_utils::_l( $start_indent, "'tag' => '{$slug}',", 1 );

                    $this->_args[ 'tag' ] = $slug;
                }

                // slug and

                $slug_and = wqg_utils::__ARRAY_VALUE( $data, 'slug_and' );

                if ( is_array( $slug_and ) && count( $slug_and ) > 0 ) {

                    $slug_and = array_unique( array_map( 'trim', $slug_and ) );

                    $code[] = wqg_utils::_l( $start_indent, "'tag__slug_and' => array('".join( "', '", $slug_and )."'),", 1 );

                    $this->_args[ 'tag__slug_and' ] = $slug_and;
                }

                // slug in

                $slug_in = wqg_utils::__ARRAY_VALUE( $data, 'slug_in' );

                if ( is_array( $slug_in ) && count( $slug_in ) > 0 ) {

                    $slug_in = array_unique( array_map( 'trim', $slug_in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'tag__slug_in' => array('".join( "', '", $slug_in )."'),", 1 );

                    $this->_args[ 'tag__slug_in' ] = $slug_in;
                }

                // in

                $in = wqg_utils::__ARRAY_VALUE( $data, 'in' );

                if ( is_array( $in ) && count( $in ) > 0 ) {

                    $in = array_unique( array_map( 'intval', $in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'tag__in' => array(".join( ", ", $in )."),", 1 );

                    $this->_args[ 'tag__in' ] = $in;
                }

                // not in

                $not_in = wqg_utils::__ARRAY_VALUE( $data, 'not_in' );

                if ( is_array( $not_in ) && count( $not_in ) > 0 ) {

                    $not_in = array_unique( array_map( 'intval', $not_in ) );

                    $code[] = wqg_utils::_l( $start_indent, "'tag__not_in' => array(".join( ", ", $not_in )."),", 1 );

                    $this->_args[ 'tag__not_in' ] = $not_in;
                }

                // not in

                $and = wqg_utils::__ARRAY_VALUE( $data, 'and' );

                if ( is_array( $and ) && count( $and ) > 0 ) {

                    $and = array_unique( array_map( 'intval', $and ) );

                    $code[] = wqg_utils::_l( $start_indent, "'tag__and' => array(".join( ", ", $and )."),", 1 );

                    $this->_args[ 'tag__and' ] = $and;
                }

                if ( count( $code ) > 0 ) {
                    $code[] = wqg_utils::_l( 0, '', 1 );
                }

            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Tags params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        private function generate_taxonomy_arg_code( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'tax' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {

                /**
                 * Taxonomy Data
                 */

                $relation = wqg_utils::__ARRAY_VALUE( $data, 'relation', 'AND' );
                $rules = wqg_utils::array_value_as_array( $data, 'rules', array() );

                $non_empty_rules_count = 0;

                if(is_array($rules) && count($rules) > 0) {

                    foreach($rules as $r) {
                        $term = wqg_utils::array_value_as_array($r,'term',array());

                        if(!empty($term)) {
                            $non_empty_rules_count += 1;
                        }
                    }
                }



                if ( count( $rules ) > 0 ) {


                    $this->_args[ 'tax_query' ] = array();

                    $code[] = wqg_utils::_l( $start_indent, "'tax_query' => array(", 1 );

                    // relation


                    if ( $non_empty_rules_count > 1 ) {
                        $code[] = wqg_utils::_l( $start_indent + 1, "'relation' => '{$relation}',", 1 );

                        $this->_args[ 'tax_query' ][ 'relation' ] = $relation;
                    }

                    // rules

                    if ( count( $rules ) > 0 ) {

                        foreach($rules as $r) {

                            $name = wqg_utils::array_value_as_string($r,'name','','trim');
                            $field = wqg_utils::array_value_as_string($r,'field','','trim');
                            $operator = wqg_utils::array_value_as_string($r,'operator','','trim');
                            $term = wqg_utils::array_value_as_array($r,'term',array());
                            $include_children = wqg_utils::array_value_as_int($r,'include_children',0);

                            if(empty($term)) {
                                continue;
                            }

                            $code[] = wqg_utils::_l( $start_indent + 1, "array(", 1 );

                            $code[] = wqg_utils::_l( $start_indent + 2, "'taxonomy' => '{$name}',", 1 );
                            $code[] = wqg_utils::_l( $start_indent + 2, "'field' => '{$field}',", 1 );

                            $code[] = wqg_utils::_l( $start_indent + 2, "'terms' => array(", 1 );

                            foreach($term as $t) {

                                $t = trim($t);

                                $code[] = wqg_utils::_l( $start_indent + 3, "'{$t}'", 1 );
                            }

                            $code[] = wqg_utils::_l( $start_indent + 2, "),", 1 );

                            $code[] = wqg_utils::_l( $start_indent + 2, "'operator' => '{$operator}',", 1 );
                            $code[] = wqg_utils::_l( $start_indent + 2, "'include_children' => ".($include_children > 0 ? 'true':'false').",", 1 );

                            $code[] = wqg_utils::_l( $start_indent + 1, "),", 1 );

                            $this->_args['tax_query'][] = array(
                                'taxonomy' => $name,
                                'field' => $field,
                                'terms' => $term,
                                'operator' => $operator,
                                'include_children' => $include_children > 0
                            );

                        }

                    }

                    $code[] = wqg_utils::_l( $start_indent, "),", 1 );


                }


            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Taxonomy params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );

        }

        public function generate_search_arg_code( $start_indent ) {

            $start_indent = (int) $start_indent;

            if ( $start_indent < 0 ) {
                $start_indent = 0;
            }

            $data = wqg_utils::__ARRAY_VALUE( $this->_data, 'search' );

            $code = array();

            if ( is_array( $data ) && count( $data ) > 0 ) {

                /**
                 * Keyword
                 */

                $keyword = wqg_utils::__ARRAY_VALUE( $data, 'keyword', '' );

                if($keyword != '') {

                    $this->_args['s'] = $keyword;

                    $code[] = wqg_utils::_l( $start_indent, "'s' => '".($keyword)."'", 1 );

                }

            }

            if(!empty($code)) {

                $content = PHP_EOL;

                $content .= wqg_utils::_l( $start_indent, "/* Search params */", 2 );

                $content .= join( '', $code );

                return $content;

            }

            return join( '', $code );


        }

    }