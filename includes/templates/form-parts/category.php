<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Category ID (#cat)</strong>Get entries associated with selected category id<br />

                <?php
                    echo wqg_categories::categories_dropdown(array(
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',

                        ),
                        'label_field' => 'name',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[id]',
                            'id' => 'category_id',
                        ),
                        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'category/id')
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
                    echo wqg_categories::categories_dropdown(array(
                        'empty_value' => array(
                            'label' => '~ Select ~',
                            'value' => '',
                        ),
                        'label_field' => 'name',
                        'value_field' => 'slug',
                        'attributes' => array(
                            'name' => 'category[name]',
                            'id' => 'category_name',

                        ),
                        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'category/name')
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
                    echo wqg_categories::categories_dropdown(array(
                        'label_field' => 'name',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[and][]',
                            'id' => 'category_and',
                            'multiple' => 'multiple',
                            'size' => 10
                        ),
                        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'category/and')
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
                    echo wqg_categories::categories_dropdown(array(
                        'label_field' => 'name',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[in][]',
                            'id' => 'category_in',
                            'multiple' => 'multiple',
                            'size' => 10
                        ),
                        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'category/in')
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
                    echo wqg_categories::categories_dropdown(array(
                        'label_field' => 'name',
                        'value_field' => 'term_id',
                        'attributes' => array(
                            'name' => 'category[not_in][]',
                            'id' => 'category_not_in',
                            'multiple' => 'multiple',
                            'size' => 10
                        ),
                        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'category/not_in')
                    ));
                ?>
            </label>

        </td>
    </tr>

</table>