<?php

    $main = wqg_main::get_instance();

    $idPrefix = $main->get_config('idPrefix');

    $wqgData = wqg_utils::get_data();

    if(empty($wqgData)) {
        $wqgData = array();
    }

    $current_dir = dirname( __FILE__ ).DIRECTORY_SEPARATOR;

    $main = wqg_main::get_instance();

    $tabs = array(
        array(
            'id'     => $idPrefix.'tab-author',
            'label'  => 'Auhtor',
            'slug'   => 'author',
            'active' => TRUE,
        ),
        array(
            'id'     => $idPrefix.'tab-category',
            'label'  => 'Category',
            'slug'   => 'category',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-tag',
            'label'  => 'Tag',
            'slug'   => 'tag',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-taxonomy',
            'label'  => 'Taxonomy',
            'slug'   => 'taxonomy',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-search',
            'label'  => 'Search',
            'slug'   => 'search',
            'active' => FALSE,
        ),

        array(
            'id'     => $idPrefix.'tab-post',
            'label'  => 'Post',
            'slug'   => 'post',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-pagination',
            'label'  => 'Pagination',
            'slug'   => 'pagination',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-sorting',
            'label'  => 'Sorting',
            'slug'   => 'sorting',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-date',
            'label'  => 'Date',
            'slug'   => 'date',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-meta',
            'label'  => 'Meta/Custom Fields',
            'slug'   => 'meta',
            'active' => FALSE,
        ),
    );


    foreach($tabs as &$t) {

        $t['active'] = wqg_utils::__ARRAY_VALUE($wqgData,'currentTab',$idPrefix.'tab-author') == $t['id'];

    }



?>
<div class="wrap" id="<?= $idPrefix.$main->get_config( 'html/ids/generator_container' ) ?>">


    <div class="tabpanel horizontal">
        <ul class="list-group tab-buttons" role="tablist">
            <li role="presentation" class="tab-button-wrapper active">
                <a href="#tab-button-params" class="tab-button" data-id="tab-button-params">Params</a>
            </li>
            <li role="presentation" class="tab-button-wrapper">
                <a href="#tab-button-code" class="tab-button" data-id="tab-button-code">Code</a>
            </li>
            <li role="presentation" class="tab-button-wrapper">
                <a href="#tab-button-preview" class="tab-button" data-id="tab-button-preview">Preview</a>
            </li>


        </ul>

        <div class="tab-contents">
            <div role="tabpanel" class="tab-pane active" id="tab-button-params">
                Params ....
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-button-code">
                Code ....
            </div>

            <div role="tabpanel" class="tab-pane" id="tab-button-preview">
                Preview ....
            </div>
        </div>
    </div>

    <h2 class="me-anjan-wqg-sub-heading">WP_Query Params</h2>


    <form action="" method="POST" class="form-horizontal" role="form" id="<?= $idPrefix.$main->get_config( 'html/ids/generator_form' ) ?>">
        <div class="me-anjan-wqg-tabpanel" id="<?= $idPrefix?>tabpanel-params">
            <!-- Nav tabs -->
            <ul class="me-anjan-wqg-tab-buttons" role="tablist">

                <?php foreach ( $tabs as $ele ): ?>
                    <li role="presentation" class="me-anjan-wqg-tab-button-wrapper <?= $ele[ 'active' ] ? 'active' : '' ?>">
                        <a href="#<?= $ele[ 'id' ] ?>" aria-controls="<?= $ele[ 'id' ] ?>"
                           class="me-anjan-wqg-tab-button" data-id="<?= $ele[ 'id' ] ?>"><?= $ele[ 'label' ] ?></a>
                    </li>
                <?php endforeach; ?>

            </ul>
            <!-- Tab panes -->
            <div class="me-anjan-wqg-tab-contents">

                <?php foreach ( $tabs as $ele ): ?>
                    <div role="tabpanel" class="me-anjan-wqg-tab-pane <?= $ele[ 'active' ] ? 'active' : '' ?>"
                         id="<?= $ele[ 'id' ] ?>">
                        <?php
                            require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/form-parts/'.$ele[ 'slug' ].'.php');
                        ?>
                    </div>
                <?php endforeach; ?>

                <div style="clear: both;"></div>

                <div class="me-anjan-wqg-buttons-container">

                    <input type="hidden" name="wqg-action" id="<?= $idPrefix?>action" value="generate-code">

                    <input type="hidden" class="wqgCurrentTab" name="currentTab" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'currentTab')?>" />

                    <button type="submit" class="button-primary">Save &amp; Generate</button>
                    <button type="submit" class="button-secondary">Preview Data</button>

                    <button type="button" id="<?= $idPrefix.$main->get_config('html/ids/reset_button')?>" class="button-primary red" style="float: right;" name="reset_wqg_data">Reset</button>
                </div>
            </div>

            <div style="clear: both;"></div>
        </div>
    </form>


    <h2 class="me-anjan-wqg-sub-heading">Generated Output</h2>

    <div class="me-anjan-wqg-output-block" id="<?= $idPrefix.$main->get_config( 'html/ids/generator_output' ) ?>">
        <textarea style="width: 80%;height: 300px;"><?php $gen = new wqg_generator( $wqgData );echo $gen->generate_code();?></textarea>
    </div>
</div>