<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Tag Slug (#tag)</strong>Get entries associated with selected tag slug<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'empty_value' => array(
                            'label' => '',
                            'value' => '',

                        ),
                        'label_field' => 'name',
                        'label_field_extra' => 'slug',
                        'value_field' => 'slug',
                        'attributes' => array(
                            'name' => 'tag[slug]',
                            'id' => 'tag_slug',
                            'data-placeholder' => ' '
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/slug')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- slug -->

    <tr>
        <td>
            <label>
                <strong>All Tag Slugs (#tag__slug_and)</strong>Get entries having all the selected tag slugs<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'slug',
                        'value_field' => 'slug',
                        'attributes' => array(
                            'name' => 'tag[slug_and][]',
                            'id' => 'tag_slug_and',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more tag slugs'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/slug_and')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- slug and -->

    <tr>
        <td>
            <label>
                <strong>Any of the Tag Slugs (#tag__slug_and)</strong>Get entries having any of the selected tag slugs<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'slug',
                        'value_field' => 'slug',
                        'attributes' => array(
                            'name' => 'tag[slug_in][]',
                            'id' => 'tag_slug_in',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more tag slugs'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/slug_in')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- slug in -->

    <tr>
        <td>
            <label>
                <strong>Tag ID (#tag_id)</strong>Get entries associated with selected tag id<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'empty_value' => array(
                            'label' => '',
                            'value' => '',

                        ),
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'tag[id]',
                            'id' => 'tag_id',
                            'data-placeholder' => ' '
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/id')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- id -->

    <tr>
        <td>
            <label>
                <strong>All Tag ID (#tag__and)</strong>Get entries having all selected tag ids<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'tag[and][]',
                            'id' => 'tag_and',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more tag id'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/and')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- and -->

    <tr>
        <td>
            <label>
                <strong>Any Tag ID (#tag__in)</strong>Get entries having any of the selected tag ids<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'tag[in][]',
                            'id' => 'tag_in',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more tag id'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/in')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- in -->

    <tr>
        <td>
            <label>
                <strong>Exclude Tag IDs (#tag__not_in)</strong>Get entries not having any of the selected tag ids<br />

                <?php
                    echo meAnjanWqg_Tags::tagsDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'tag[not_in][]',
                            'id' => 'tag_not_in',
                            'multiple' => 'multiple',
                            'data-placeholder' => 'Select one or more tag id'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'tag/not_in')
                    ));
                ?>
            </label>
        </td>
    </tr> <!-- not in -->

</table>