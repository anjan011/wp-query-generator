<?php

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'slug',
        'attributes' => array(
            'name' => 'tag[slug]',
            /*'multiple' => 'multiple',
            'size' => 10*/
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/slug')
    ));

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'term_id',
        'attributes' => array(
            'name' => 'tag[id]',
            /*'multiple' => 'multiple',
            'size' => 10*/
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/id')
    ));

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'term_id',
        'attributes' => array(
            'name' => 'tag[and][]',
            'multiple' => 'multiple',
            'size' => 10
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/and')
    ));

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'term_id',
        'attributes' => array(
            'name' => 'tag[in][]',
            'multiple' => 'multiple',
            'size' => 10
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/in')
    ));

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'term_id',
        'attributes' => array(
            'name' => 'tag[not_in][]',
            'multiple' => 'multiple',
            'size' => 10
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/not_in')
    ));

    echo wqg_tags::tags_dropdown(array(
        'label_field' => 'name',
        'value_field' => 'term_id',
        'attributes' => array(
            'name' => 'tag[and][]',
            'multiple' => 'multiple',
            'size' => 10
        ),
        'selected' => wqg_utils::__ARRAY_VALUE($wqgData,'tag/and')
    ));