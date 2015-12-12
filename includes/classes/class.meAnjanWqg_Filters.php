<?php

    /**
     * Class ume_actions
     *
     * Handles wordpress actions
     */
    class meAnjanWqg_Filters {

        /**
         * Add filters here
         */

        public function init() {

            add_filter(
                'plugin_action_links_'.ME_ANJAN_PLUGIN_WQG_BASE_FILE_PATH,
                array( $this, '__filter_AddActionLinks' )
            );

        }

        /**
         * Add plugin action links, which will be visible in Wordpress plugins list
         *
         * @param $links
         *
         * @return array
         */

        public function __filter_AddActionLinks( $links ) {

            $mylinks = array(
                '<a href="'.menu_page_url( meAnjanWqg_Actions::GENERATOR_PAGE_SLUG, FALSE ).'">Generate Query Code</a>',
            );

            return array_merge( $mylinks, $links );
        }

    }