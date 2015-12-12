<?php return false;?>
<table class="form-table">

    <tr>
        <td>
            <label>
                <strong>Post Type (#post_type)</strong>Get entries by selected post type<br/>
                <?php

                    $post_types = get_post_types( array(
                        '_builtin' => TRUE,
                    ) );

                    asort( $post_types );

                ?>

                <select id="post_type" name="post[post_type][]" style="1" class="chosen" multiple>
                    <option value="any">Any Type</option>
                    <?php foreach ( $post_types as $type ): ?>
                        <option value="<?= $type ?>"
                                <?php if (meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_type', 'post' ) == $type): ?>selected<?php endif; ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Post ID (#p)</strong>Get entries by selected post id<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => 'post',
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'post_title',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_id]',
                            'id'    => 'post_id',
                            'class' => 'chosen',
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_id' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_id -->
    <tr>
        <td>
            <label>
                <strong>Post Slug (#name)</strong>Get entries by selected post slug<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => 'post',
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'post_name',
                        'value_field' => 'post_name',
                        'attributes'  => array(
                            'name'  => 'post[post_slug]',
                            'id'    => 'post_slug',
                            'class' => 'chosen',
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_slug' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_slug -->

    <tr>
        <td>
            <label>
                <strong>Page ID (#p)</strong>Get entries by selected post id<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => 'page',
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'post_title',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[page_id]',
                            'id'    => 'page_id',
                            'class' => 'chosen',
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/page_id' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- page_id -->
    <tr>
        <td>
            <label>
                <strong>Post Slug (#name)</strong>Get entries by selected post slug<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => 'page',
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'post_name',
                        'value_field' => 'post_name',
                        'attributes'  => array(
                            'name'  => 'post[page_slug]',
                            'id'    => 'page_slug',
                            'class' => 'chosen',
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/page_slug' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- page_slug -->
</table>