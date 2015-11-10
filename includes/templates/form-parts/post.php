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

                    $selectedPostTypes = wqg_utils::array_value_as_array($wqgData,'post/post_type',array());

                ?>

                <select id="post_type" name="post[post_type][]" style="1" class="chosen" multiple data-placeholder="Select post type(s)">
                    <option value="any">Any Type</option>
                    <?php foreach ( $post_types as $type ): ?>
                        <option value="<?= $type ?>"
                                <?php if (in_array($type,$selectedPostTypes)): ?>selected<?php endif; ?>><?= $type ?></option>
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
                    echo wqg_posts::posts_dropdown( array(
                        'post_type'   => array('post','any'),
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'post_title',
                        'label_field_extra' => 'ID',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_id]',
                            'id'    => 'post_id',
                            'class' => 'chosen',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more posts'
                        ),
                        'selected'    => wqg_utils::__ARRAY_VALUE( $wqgData, 'post/post_id' ),
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
                    echo wqg_posts::posts_dropdown( array(
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
                        'selected'    => wqg_utils::__ARRAY_VALUE( $wqgData, 'post/post_slug' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_slug -->
</table>