<?php

    /**
     * Class ume_actions
     *
     * Handles wordpress actions
     */
    class meAnjanWqg_Actions {

        /* Ajax Actions */

        const AJAX_ACTION_TEST = 'meAnjanWqg_Test';
        const AJAX_ACTION_GENERATE_CODE = 'meAnjanWqg_GenerateCode';
        const AJAX_ACTION_AUTHOR_ID_AUTOCOMLETE = 'meAnjanWqg_AuthorIdAutocomplete';
        const AJAX_ACTION_AUTHOR_NAME_AUTOCOMLETE = 'meAnjanWqg_AuthorNameAutocomplete';
        const AJAX_ACTION_TAXONOMY_TERMS = 'meAnjanWqg_TaxonomyTerms';
        const AJAX_ACTION_POST_LIST = 'meAnjan_WqgPostList';
        const AJAX_ACTION_DATA_PREVIEW = 'meAnjanWqg_dataPreview';

        /* Page slugs */

        const GENERATOR_PAGE_SLUG = 'wp-query-generator';

        /* Other Constants */

        const CODEMIRROR_THEME = 'dracula';



        /**
         * Add all actions here
         */

        public function init() {

            add_action( # add admin menu links
                'admin_menu',
                array( $this, '__action_AdminMenu' )
            );

            add_action( # enqueue scripts needed
                'admin_enqueue_scripts',
                array( $this, '__action_AdminEnqueueScriptsAndStyles' )
            );


            add_action( # ajax action for generating code
                'wp_ajax_'.(self::AJAX_ACTION_GENERATE_CODE),
                array( $this, '__action_GenerateCode' )
            );


            add_action( # ajax action for test
                'wp_ajax_'.(self::AJAX_ACTION_TEST),
                array( $this, '__action_TestAjax' )
            );

            add_action( # gets taxonomy terms via ajax
                'wp_ajax_'.self::AJAX_ACTION_TAXONOMY_TERMS,
                array($this,'__action_TaxonomyTerms')
            );


            add_action( # ajax posts lists
                'wp_ajax_'.self::AJAX_ACTION_POST_LIST,
                array($this,'__action_PostList')
            );

            add_action( # ajax data preview
                'wp_ajax_'.self::AJAX_ACTION_DATA_PREVIEW,
                array($this,'__action_DataPreview')
            );

        }

        /**
         * Test playground
         */

        public function __action_TestAjax() {

            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/test-ajax.php');

            exit();
        }

        /**
         * Action: Enqueue admin scripts and styles needed
         *
         * @param $hook
         */

        public function __action_AdminEnqueueScriptsAndStyles( $hook ) {

            $main = meAnjanWqg_Main::getInstance();

            /* Styles */

            if ( $hook == 'tools_page_'.self::GENERATOR_PAGE_SLUG ) {


                wp_enqueue_style(
                    'wqg_chosen',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/chosen/chosen.min.css'
                );

                wp_enqueue_style(
                    'me_anjan_wqg_sh_core',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/SyntaxHighlighter/styles/shCore.css'
                );

                wp_enqueue_style(
                    'me_anjan_wqg_sh_core_default',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/SyntaxHighlighter/styles/shCoreDefault.css'
                );

                wp_enqueue_style(
                    'me_anjan_wqg_sh_core_default',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/SyntaxHighlighter/styles/shThemeDefault.css'
                );

                wp_enqueue_style(
                    'wqg_main_style',
                    ME_ANJAN_WQG_URL_ROOT.'assets/css/main.css'
                );

            }

            /* Scripts */

            if ( $hook == 'tools_page_'.self::GENERATOR_PAGE_SLUG ) {

                wp_deregister_script('underscore');

                wp_register_script('underscore',ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/underscore/underscore-min.js');

                wp_enqueue_script( 'underscore' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'jquery-ui-draggable' );



                wp_enqueue_script(
                    'wqg_chosen',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/chosen/chosen.jquery.min.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'me_anjan_wqg_sh_core',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/SyntaxHighlighter/scripts/shCore.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'me_anjan_wqg_sh_brush_php',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/lib/SyntaxHighlighter/scripts/shBrushPhp.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );


                wp_enqueue_script(
                    'wqg_main_script',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/main.js',
                    array( 'jquery' ),
                    '1.0',
                    TRUE
                );

                wp_enqueue_script(
                    'wqg_taxonomy_script',
                    ME_ANJAN_WQG_URL_ROOT.'assets/js/taxonomy.js',
                    array( 'underscore','jquery','wqg_main_script' ),
                    '1.0',
                    TRUE
                );

                // Data for javascript

                $jsData = $this->prepareJsData();

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

        public function __action_AdminMenu() {

            // Add a new sub-menu under tools, to access generator form

            add_management_page(
                __( 'WP_Query Generator', ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN ),
                __( 'WP_Query Generator', ME_ANJAN_PLUGIN_WQG_TEXT_DOMAIN ),
                'manage_options',
                self::GENERATOR_PAGE_SLUG,
                array( $this, '__adminMenuPage_QueryGeneratorForm' )
            );

        }

        /**
         * The query generator form here
         */

        public function __adminMenuPage_QueryGeneratorForm() {

            if(isset($_POST['wqg-action']) && $_POST['wqg-action'] == 'reset-data') {

                meAnjanWqg_Utils::saveData(array());

            }

            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/form-parts/index.php');

        }

        /**
         * Generate code action handler
         */

        public function __action_GenerateCode() {


            $data = stripslashes_deep($_POST);

            meAnjanWqg_Utils::saveData($data);

            $generator = new meAnjanWqg_Generator( $data );

            echo($generator->generateCode());

            exit();

        }


        public function __action_TaxonomyTerms() {

            $res = meAnjanWqg_Taxonomies::getAllTerms($_GET);

            echo json_encode($res);

            exit();
        }

        /**
         * Gets list of post entries for AJAX
         */

        public function __action_PostList() {

            $posts = array();

            meAnjanWqg_Posts::getPostsMinimal($posts,$_GET);

            echo json_encode($posts);

            exit();

        }

        /**
         * Generate html markup for data preview
         */

        public function __action_DataPreview() {

            if(!empty($_POST)) {

                $data = stripslashes_deep($_POST);

                meAnjanWqg_Utils::saveData($data);
            }


            $wqgData = meAnjanWqg_Utils::getData();

            if(empty($wqgData)) {
                $wqgData = array();
            }

            $gen = new meAnjanWqg_Generator( $wqgData );

            $gen->generateCode();

            $args = $gen->getGeneratedArgs();

            $query = new WP_Query($args);

            $posts = $query->get_posts();

            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/preview/posts-list.php');

            exit();

        }

        /**
         * Prepares the data to be passed to javascript
         *
         * @return array
         *
         */
        private function prepareJsData() {

            $main = meAnjanWqg_Main::getInstance();

            $jsData = array(
                'idPrefix'           => $main->getConfig( 'idPrefix' ),
                'ajax_url'           => array(
                    'form_generate'            => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_GENERATE_CODE
                    ),
                    'author_id_autocomplete'   => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_AUTHOR_ID_AUTOCOMLETE
                    ),
                    'author_name_autocomplete' => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_AUTHOR_NAME_AUTOCOMLETE
                    ),
                    'taxonomy_terms'           => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_TAXONOMY_TERMS
                    ),
                    'data_preview'             => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_DATA_PREVIEW
                    ),
                    'post_list'                => meAnjanWqg_Utils::wpAjaxUrl(
                        self::AJAX_ACTION_POST_LIST
                    ),
                ),
                'codeMirrorTheme'    => self::CODEMIRROR_THEME,
                'html_ids'           => $main->getConfig( 'html/ids' ),
                'taxonomies'         => meAnjanWqg_Taxonomies::getTaxonomies(),
                'taxonomy_fields'    => array(
                    array(
                        'label'   => 'ID',
                        'value'   => 'term_id',
                        'default' => 1
                    ),
                    array(
                        'label'   => 'Name',
                        'value'   => 'name',
                        'default' => 0
                    ),
                    array(
                        'label'   => 'Slug',
                        'value'   => 'slug',
                        'default' => 0
                    ),
                ),
                'taxonomy_operators' => array(
                    array(
                        'value'   => 'IN',
                        'default' => 1,
                        'label'   => 'Match Any'
                    ),

                    array(
                        'value'   => 'NOT IN',
                        'default' => 0,
                        'label'   => 'Match None'
                    ),

                    array(
                        'value'   => 'AND',
                        'default' => 0,
                        'label'   => 'Match All'
                    ),

                    array(
                        'value'   => 'EXISTS',
                        'default' => 0,
                        'label'   => 'Exists'
                    ),

                    array(
                        'value'   => 'NOT EXISTS',
                        'default' => 0,
                        'label'   => 'Not Exists'
                    ),
                )
            );

            return $jsData;
        }

    }