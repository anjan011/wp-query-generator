<?php

    /**
     * Class ume_actions
     *
     * Handles wordpress actions
     */
    class wqg_actions {

        /* Ajax Actions */

        const AJAX_ACTION_TEST = 'wqg_test_15265';
        const AJAX_ACTION_GENERATE_CODE = 'wqg_generate_code';
        const AJAX_ACTION_AUTHOR_ID_AUTOCOMLETE = 'wqg_author_id_autocomplete';
        const AJAX_ACTION_AUTHOR_NAME_AUTOCOMLETE = 'wqg_author_name_autocomplete';
        const AJAX_ACTION_TAXONOMY_TERMS = 'me_anjan_wqg_taxonomy_terms';
        const AJAX_ACTION_POST_LIST = 'me_anjan_wqg_post_list';

        /* Page slugs */

        const GENERATOR_PAGE_SLUG = 'wp-query-generator';

        /* Other Constants */

        const CODEMIRROR_THEME = 'dracula';



        /**
         * Add actions here
         */

        public function init() {

            add_action( 'admin_menu', array( $this, '__action__admin_menu' ) );

            add_action( 'admin_enqueue_scripts', array( $this, '__action__admin_enqueue_scripts' ) );

            add_action(
                'wp_ajax_nopriv_'.(self::AJAX_ACTION_GENERATE_CODE),
                array( $this, 'generate_code' )
            );

            add_action(
                'wp_ajax_'.(self::AJAX_ACTION_GENERATE_CODE),
                array( $this, 'generate_code' )
            );

            /**
             * Test AJAX action
             */

            add_action(
                'wp_ajax_'.(self::AJAX_ACTION_TEST),
                array( $this, 'test_ajax' )
            );

            add_filter( 'plugin_action_links_'.ME_ANJAN_PLUGIN_WQG_BASE_FILE_PATH, array( $this, 'add_action_links' ) );

            add_action('wp_ajax_me_anjan_wqg_taxonomy_terms', array($this,'__action_taxonomy_terms'));


            add_action('wp_ajax_'.self::AJAX_ACTION_POST_LIST, array($this,'__action_post_list'));

        }

        public function test_ajax() {

            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/test-ajax.php');

            exit();
        }

        /**
         * Action: Enqueue admin scripts and styles needed
         *
         * @param $hook
         */

        public function __action__admin_enqueue_scripts( $hook ) {

            $main = wqg_main::get_instance();

            /* Styles */

            if ( $hook == 'tools_page_'.self::GENERATOR_PAGE_SLUG ) {


                wp_enqueue_style( 'wqg_codemirror_style', ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/lib/codemirror.css' );
                wp_enqueue_style( 'wqg_codemirror_theme_'.self::CODEMIRROR_THEME, ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/theme/'.self::CODEMIRROR_THEME.'.css', array( 'wqg_codemirror_style' ) );

                wp_enqueue_style( 'wqg_main_style', ME_ANJAN_PLUGIN_WQG_URL.'assets/css/main.css' );

            }

            /* Scripts */

            if ( $hook == 'tools_page_'.self::GENERATOR_PAGE_SLUG ) {

                wp_deregister_script('underscore');

                wp_register_script('underscore',ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/underscore/underscore-min.js');

                wp_enqueue_script( 'underscore' );
                wp_enqueue_script( 'jquery' );

                wp_enqueue_style(
                    'wqg_chosen',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/chosen/chosen.min.css'
                );

                wp_enqueue_script(
                    'wqg_chosen',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/chosen/chosen.jquery.min.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );


                wp_enqueue_script(
                    'wqg_codemirror',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/lib/codemirror.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_php',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/php/php.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_xml',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/xml/xml.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_clike',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/clike/clike.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_htmlmixed',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/htmlmixed/htmlmixed.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_javascript',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/javascript/javascript.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_codemirror_mode_css',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/lib/codemirror-5.6/mode/css/css.js',
                    array( 'wqg_codemirror' ),
                    '1.0',
                    TRUE
                );



                wp_enqueue_script(
                    'wqg_main_script',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/main.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_taxonomy_script',
                    ME_ANJAN_PLUGIN_WQG_URL.'assets/js/taxonomy.js',
                    array( 'jquery','underscore','wqg_main_script' ),
                    '1.0',
                    TRUE
                );

                // Data for javascript

                $jsData = array(
                    'idPrefix' => $main->get_config('idPrefix'),
                    'ajax_url'        => array(
                        'form_generate'            => wqg_utils::wp_ajax_url(
                            self::AJAX_ACTION_GENERATE_CODE
                        ),
                        'author_id_autocomplete'   => wqg_utils::wp_ajax_url(
                            self::AJAX_ACTION_AUTHOR_ID_AUTOCOMLETE
                        ),
                        'author_name_autocomplete' => wqg_utils::wp_ajax_url(
                            self::AJAX_ACTION_AUTHOR_NAME_AUTOCOMLETE
                        ),
                        'taxonomy_terms' => wqg_utils::wp_ajax_url(
                            self::AJAX_ACTION_TAXONOMY_TERMS
                        ),
                    ),
                    'codeMirrorTheme' => self::CODEMIRROR_THEME,
                    'html_ids' => $main->get_config('html/ids'),
                    'taxonomies' => wqg_taxonomies::get_taxonomies(),
                    'taxonomy_fields' => array(
                        array(
                            'label' => 'ID',
                            'value' => 'term_id',
                            'default' => 1
                        ),
                        array(
                            'label' => 'Name',
                            'value' => 'name',
                            'default' => 0
                        ),
                        array(
                            'label' => 'Slug',
                            'value' => 'slug',
                            'default' => 0
                        ),
                    ),
                    'taxonomy_operators' => array(
                        array(
                            'value' => 'IN',
                            'default' => 1,
                            'label' => 'Match Any'
                        ),

                        array(
                            'value' => 'NOT IN',
                            'default' => 0,
                            'label' => 'Match None'
                        ),

                        array(
                            'value' => 'AND',
                            'default' => 0,
                            'label' => 'Match All'
                        ),

                        array(
                            'value' => 'EXISTS',
                            'default' => 0,
                            'label' => 'Exists'
                        ),

                        array(
                            'value' => 'NOT EXISTS',
                            'default' => 0,
                            'label' => 'Not Exists'
                        ),
                    )
                );

                wp_localize_script(
                    'wqg_main_script',
                    'meAnjanWqgData',
                    $jsData
                );


            }

        }

        /**
         * Action: Add admin menu entries
         *
         * Currently that is one page added under tools section
         */

        public function __action__admin_menu() {

            // Add a new sub-menu under tools, to access generator form

            add_management_page(
                __( 'WP_Query Generator', ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN ),
                __( 'WP_Query Generator', ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN ),
                'manage_options',
                self::GENERATOR_PAGE_SLUG,
                array( $this, 'query_generator_form' )
            );

        }

        /**
         * The query generator form here
         */

        public function query_generator_form() {

            if(isset($_POST['wqg-action']) && $_POST['wqg-action'] == 'reset-data') {

                wqg_utils::save_data(array());

            }

            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/form-parts/index.php');

        }

        /**
         * Generate code action handler
         */

        public function generate_code() {


            wqg_utils::save_data($_POST);

            $generator = new wqg_generator( $_POST );

            echo($generator->generate_code());

            exit();

        }

        /**
         * Add plugin action links, which will be visible in Wordpress plugins list
         *
         * @param $links
         *
         * @return array
         */

        function add_action_links( $links ) {

            $mylinks = array(
                '<a href="'.menu_page_url( self::GENERATOR_PAGE_SLUG, FALSE ).'">Generate Query Code</a>',
            );

            return array_merge( $mylinks, $links );
        }

        function __action_taxonomy_terms() {

            $res = wqg_taxonomies::get_all_terms($_GET);

            echo json_encode($res);

            exit();
        }

        function __action_post_list() {

            echo wqg_posts::posts_dropdown($_GET);

            exit();

        }


    }