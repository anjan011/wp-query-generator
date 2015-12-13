<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Category ID (#cat)</strong>Get entries associated with selected category id<br />

                <?php
                    echo meAnjanWqg_Categories::categoriesDropdown(array(
                        'empty_value' => array(
                            'label' => '',
                            'value' => '',

                        ),
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[id]',
                            'id' => 'category_id',
                            'data-placeholder' => ' ',
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'category/id')
                    ));
                ?>
            </label>
        </td>
    </tr>
    <tr>
        <td>
            <label>

                <strong>Category Name (#category_name)</strong>Get entries associated with selected category name (using slug)<br />

                <?php
                    echo meAnjanWqg_Categories::categoriesDropdown(array(
                        'empty_value' => array(
                            'label' => '',
                            'value' => '',
                        ),
                        'label_field' => 'name',
                        'label_field_extra' => 'slug',
                        'value_field' => 'slug',
                        'attributes' => array(
                            'name' => 'category[name]',
                            'id' => 'category_name',
                            'data-placeholder' => ' '

                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'category/name')
                    ));
                ?>
            </label>

        </td>
    </tr>

    <tr>
        <td>
            <label>

                <strong>Category Ids (#category__and)</strong>Get entries associated with <b>ALL</b> of the selected category ids<br />

                <?php
                    echo meAnjanWqg_Categories::categoriesDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[and][]',
                            'id' => 'category_and',
                            'multiple' => 'multiple',
                            'size' => 10,
                            'data-placeholder' => 'Select one or more categories'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'category/and')
                    ));
                ?>
            </label>

        </td>
    </tr>

    <tr>
        <td>
            <label>

                <strong>Category Ids in (#category__in)</strong>Get entries associated with <b>ANY</b> of the selected category ids<br />

                <?php
                    echo meAnjanWqg_Categories::categoriesDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[in][]',
                            'id' => 'category_in',
                            'multiple' => 'multiple',
                            'size' => 10,
                            'data-placeholder' => 'Select one or more categories'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'category/in')
                    ));
                ?>
            </label>

        </td>
    </tr>

    <tr>
        <td>
            <label>

                <strong>Exclude Categories (#category__not_in)</strong>Get entries <b>NOT</b> associated with any of the selected category ids<br />

                <?php
                    echo meAnjanWqg_Categories::categoriesDropdown(array(
                        'label_field' => 'name',
                        'label_field_extra' => 'term_id',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[not_in][]',
                            'id' => 'category_not_in',
                            'multiple' => 'multiple',
                            'size' => 10,
                            'data-placeholder' => 'Select one or more categories'
                        ),
                        'selected' => meAnjanWqg_Utils::arrayValue($wqgData,'category/not_in')
                    ));
                ?>
            </label>

        </td>
    </tr>

</table>