<table class="form-table">

    <tr>
        <td>
            <label>
                <strong>Post Status (#post_status)</strong>Get entries by selected status<br/>
                <?php

                    $post_status_list = get_post_stati(array(),'names');

                    asort( $post_status_list );

                    $selectedPostStatus = meAnjanWqg_Utils::arrayValueAsArray($wqgData,'post/post_status',array('publish'));

                ?>

                <select id="<?= $idPrefix?>post-status" name="post[post_status][]" style="1" class="chosen" multiple data-placeholder="Select one or more post status">
                    <option value="any">Any Type</option>
                    <?php foreach ( $post_status_list as $status ): ?>
                        <option value="<?= $status ?>"
                                <?php if (in_array($status,$selectedPostStatus)): ?>selected<?php endif; ?>><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Post Type (#post_type)</strong>Get entries by selected post type<br/>
                <?php

                    $post_types = get_post_types( array(
                        '_builtin' => TRUE,
                    ) );

                    asort( $post_types );

                    $selectedPostTypes = meAnjanWqg_Utils::arrayValueAsArray($wqgData,'post/post_type',array('post'));

                ?>

                <select id="<?= $idPrefix?>post-type" name="post[post_type][]" style="1" class="chosen" multiple data-placeholder="Select post type(s)">
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
                <strong>Post ID (#p)</strong>Get posts by id<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => $selectedPostTypes,
                        'nopaging'    => TRUE,
                        /*'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),*/
                        'label_field' => 'post_title',
                        'label_field_extra' => 'ID',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_id][]',
                            'id'    => $idPrefix.'post-id',
                            'class' => 'chosen',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more posts'
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
                <strong>Exclude Post ID (#post__not_in)</strong>Exclude selected posts<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => $selectedPostTypes,
                        'nopaging'    => TRUE,
                        'label_field' => 'post_title',
                        'label_field_extra' => 'ID',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_id_not_in][]',
                            'id'    => $idPrefix.'post-id-not-in',
                            'class' => 'chosen',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more posts'
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_id_not_in' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_id_not_in -->

    <tr>
        <td>
            <label>
                <strong>Post Slug (#name)</strong>Get entries by selected post slug<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => $selectedPostTypes,
                        'nopaging'    => TRUE,
                        'empty_value' => array(
                            'label' => '',
                            'value' => '',
                        ),
                        'label_field' => 'post_name',
                        'value_field' => 'post_name',
                        'attributes'  => array(
                            'name'  => 'post[post_slug]',
                            'id'    => $idPrefix.'post-slug',
                            'class' => 'chosen',
                            'data-placeholder' => ' '
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
                <strong>Parent Post (#post_parent)</strong>Get child posts<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => $selectedPostTypes,
                        'nopaging'    => TRUE,
                        'label_field' => 'post_title',
                        'label_field_extra' => 'ID',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_parent][]',
                            'id'    => $idPrefix.'post-parent',
                            'class' => 'chosen',
                            'data-placeholder' => 'Select one or more posts',
                            'multiple' => 'multiple'
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_parent' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_parent -->

    <tr>
        <td>
            <label>
                <strong>Exclude Parent Posts (#post_parent__not_in)</strong>Exclude posts with these parent posts<br/>

                <?php
                    echo meAnjanWqg_Posts::postsDropdown( array(
                        'post_type'   => $selectedPostTypes,
                        'nopaging'    => TRUE,
                        'label_field' => 'post_title',
                        'label_field_extra' => 'ID',
                        'value_field' => 'ID',
                        'attributes'  => array(
                            'name'  => 'post[post_parent_not_in][]',
                            'id'    => $idPrefix.'post-parent-not-in',
                            'class' => 'chosen',
                            'data-placeholder' => 'Select one or more posts',
                            'multiple' => 'multiple'
                        ),
                        'selected'    => meAnjanWqg_Utils::arrayValue( $wqgData, 'post/post_parent_not_in' ),
                    ) );
                ?>
            </label>
        </td>
    </tr> <!-- post_parent__not_in -->

</table>