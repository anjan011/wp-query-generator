<?php

    $main = meAnjanWqg_Main::getInstance();

    $idPrefix = $main->getConfig( 'idPrefix' );

    $wqgData = meAnjanWqg_Utils::getData();

    if ( empty($wqgData) ) {
        $wqgData = array();
    }

    $current_dir = dirname( __FILE__ ).DIRECTORY_SEPARATOR;

    $main = meAnjanWqg_Main::getInstance();

    $tabs = array(
        array(
            'id'     => $idPrefix.'tab-author',
            'label'  => 'Author',
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
            'id'     => $idPrefix.'tab-date',
            'label'  => 'Date (Simple)',
            'slug'   => 'date',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-date-query',
            'label'  => 'Date (Advanced)',
            'slug'   => 'date-query',
            'active' => FALSE,
        ),

        array(
            'id'     => $idPrefix.'tab-meta',
            'label'  => 'Meta/Custom Field',
            'slug'   => 'meta',
            'active' => FALSE,
        ),

        array(
            'id'     => $idPrefix.'tab-meta-query',
            'label'  => 'Meta Query',
            'slug'   => 'meta-query',
            'active' => FALSE,
        ),

        array(
            'id'     => $idPrefix.'tab-sorting',
            'label'  => 'Sorting',
            'slug'   => 'sorting',
            'active' => FALSE,
        ),
        array(
            'id'     => $idPrefix.'tab-pagination',
            'label'  => 'Pagination',
            'slug'   => 'pagination',
            'active' => FALSE,
        ),
    );

    $currentTab = trim(meAnjanWqg_Utils::arrayValue( $wqgData, 'currentTab' ));

    if($currentTab == '') {
        $currentTab = $idPrefix.'tab-author';
    }

    foreach ( $tabs as &$t ) {

        $t[ 'active' ] = ($currentTab == $t[ 'id' ]);

    }

?>
<div class="wrap" id="<?= $idPrefix.$main->getConfig( 'html/ids/generator_container' ) ?>">

    <h2>WP_Query Parameters Generator</h2>

    <form action="" method="POST" class="form-horizontal" role="form"
          id="<?= $idPrefix.$main->getConfig( 'html/ids/generator_form' ) ?>">

        <div class="me-anjan-wqg-tabpanel horizontal">
            <ul class="me-anjan-wqg-tab-buttons clearfix" role="tablist">
                <li role="presentation" class="me-anjan-wqg-tab-button-wrapper active">
                    <a href="#me-anjan-wqg-tab-button-params" class="me-anjan-wqg-tab-button"
                       data-id="tab-button-params">Params</a>
                </li>
                <li role="presentation" class="me-anjan-wqg-tab-button-wrapper">
                    <a href="#me-anjan-wqg-tab-button-code" class="me-anjan-wqg-tab-button" data-id="tab-button-code">Generated
                        Code</a>
                </li>
                <li role="presentation" class="me-anjan-wqg-tab-button-wrapper">
                    <a href="#me-anjan-wqg-tab-button-preview" class="me-anjan-wqg-tab-button"
                       data-id="tab-button-preview">Preview</a>
                </li>


            </ul>

            <div class="me-anjan-wqg-tab-contents">
                <div role="tabpanel" class="me-anjan-wqg-tab-pane active" id="me-anjan-wqg-tab-button-params">
                    <div class="me-anjan-wqg-tabpanel" id="<?= $idPrefix ?>tabpanel-params">
                        <!-- Nav tabs -->
                        <ul class="me-anjan-wqg-tab-buttons" role="tablist">

                            <?php foreach ( $tabs as $ele ): ?>
                                <li role="presentation"
                                    class="me-anjan-wqg-tab-button-wrapper <?= $ele[ 'active' ] ? 'active' : '' ?>">
                                    <a href="#<?= $ele[ 'id' ] ?>" aria-controls="<?= $ele[ 'id' ] ?>"
                                       class="me-anjan-wqg-tab-button"
                                       data-id="<?= $ele[ 'id' ] ?>"><?= $ele[ 'label' ] ?></a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                        <!-- Tab panes -->
                        <div class="me-anjan-wqg-tab-contents">

                            <?php foreach ( $tabs as $ele ): ?>
                                <div role="tabpanel"
                                     class="me-anjan-wqg-tab-pane <?= $ele[ 'active' ] ? 'active' : '' ?>"
                                     id="<?= $ele[ 'id' ] ?>">
                                    <?php
                                        require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/form-parts/'.$ele[ 'slug' ].'.php');
                                    ?>
                                </div>
                            <?php endforeach; ?>

                            <div style="clear: both;"></div>

                            <div class="me-anjan-wqg-buttons-container">

                                <input type="hidden" name="wqg-action" id="<?= $idPrefix ?>action"
                                       value="generate-code">

                                <input type="hidden" class="wqgCurrentTab" name="currentTab"
                                       value="<?= meAnjanWqg_Utils::arrayValue( $wqgData, 'currentTab' ) ?>"/>

                                <button type="submit" class="button-primary">Save &amp; Generate</button>

                                <button type="button" id="<?= $idPrefix.$main->getConfig( 'html/ids/reset_button' ) ?>"
                                        class="button-primary red" name="reset_wqg_data">Reset
                                </button>
                            </div>
                        </div>

                        <div style="clear: both;"></div>
                    </div>

                </div>
                <div role="tabpanel" class="me-anjan-wqg-tab-pane" id="me-anjan-wqg-tab-button-code">
                    <?php require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/output/index.php'); ?>
                </div>

                <div role="tabpanel" class="me-anjan-wqg-tab-pane" id="me-anjan-wqg-tab-button-preview">
                    <?php require_once(ME_ANJAN_PLUGIN_WQG_DIR.'includes/templates/preview/index.php'); ?>
                </div>
            </div>
        </div>

    </form>

</div>