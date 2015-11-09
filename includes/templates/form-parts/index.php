<?php

    $wqgData = wqg_utils::get_data();

    if(empty($wqgData)) {
        $wqgData = array();
    }

    $current_dir = dirname( __FILE__ ).DIRECTORY_SEPARATOR;

    $main = wqg_main::get_instance();

    $tabs = array(
        array(
            'id'     => 'tab_author',
            'label'  => 'Auhtor',
            'slug'   => 'author',
            'active' => TRUE,
        ),
        array(
            'id'     => 'tab_category',
            'label'  => 'Category',
            'slug'   => 'category',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_tag',
            'label'  => 'Tag',
            'slug'   => 'tag',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_taxonomy',
            'label'  => 'Taxonomy',
            'slug'   => 'taxonomy',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_search',
            'label'  => 'Search',
            'slug'   => 'search',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_page_post',
            'label'  => 'Page &amp; Post',
            'slug'   => 'page-post',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_pagination',
            'label'  => 'Pagination',
            'slug'   => 'pagination',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_sorting',
            'label'  => 'Sorting',
            'slug'   => 'sorting',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_date',
            'label'  => 'Date',
            'slug'   => 'date',
            'active' => FALSE,
        ),
        array(
            'id'     => 'tab_meta',
            'label'  => 'Meta/Custom Fields',
            'slug'   => 'meta',
            'active' => FALSE,
        ),
    );


    foreach($tabs as &$t) {

        $t['active'] = wqg_utils::__ARRAY_VALUE($wqgData,'currentTab','tab_author') == $t['id'];

    }



?>
<div class="wrap" id="<?= $main->get_config( 'html/ids/generator_container' ) ?>">

    <h2>WP_Query Params</h2>


    <form action="" method="POST" class="form-horizontal" role="form"
          id="<?= $main->get_config( 'html/ids/generator_form' ) ?>">
        <div class="tabpanel">
            <!-- Nav tabs -->
            <ul class="list-group tab-buttons" role="tablist">

                <?php foreach ( $tabs as $ele ): ?>
                    <li role="presentation" class="tab-button-wrapper <?= $ele[ 'active' ] ? 'active' : '' ?>">
                        <a href="#<?= $ele[ 'id' ] ?>" aria-controls="<?= $ele[ 'id' ] ?>"
                           class="tab-button" data-id="<?= $ele[ 'id' ] ?>"><?= $ele[ 'label' ] ?></a>
                    </li>
                <?php endforeach; ?>

            </ul>
            <!-- Tab panes -->
            <div class="tab-contents">

                <?php foreach ( $tabs as $ele ): ?>
                    <div role="tabpanel" class="tab-pane <?= $ele[ 'active' ] ? 'active' : '' ?>"
                         id="<?= $ele[ 'id' ] ?>">
                        <?php
                            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/form-parts/'.$ele[ 'slug' ].'.php');
                        ?>
                    </div>
                <?php endforeach; ?>

                <div style="clear: both;"></div>

                <div class="buttons-container">

                    <input type="hidden" name="wqg-action" id="me-anjan-wqg-action" value="generate-code">

                    <input type="hidden" class="wqgCurrentTab" name="currentTab" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'currentTab')?>" />

                    <button type="submit" class="button-primary">Save &amp; Generate</button>
                    <button type="submit" class="button-secondary">Preview Data</button>

                    <button type="button" id="me-anjan-wqg-reset-data" class="button-primary red" style="float: right;" name="reset_wqg_data">Reset</button>
                </div>
            </div>

            <div style="clear: both;"></div>
        </div>
    </form>


    <h2>Generated Output</h2>

    <div class="output-block">
        <textarea style="width: 80%;height: 300px;" id="<?= $main->get_config( 'html/ids/generator_output' ) ?>"><?php $gen = new wqg_generator( $wqgData );echo $gen->generate_code();?></textarea>
    </div>
</div>