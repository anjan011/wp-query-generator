<table class="form-table">

    <tr>
        <td>
            <label>
                <strong>Sort By (#orderby)</strong>Order by field<br/>
                <?php
                    $orderByKeys = wqg_posts::getPostOrderByFields();

                    $selectedOrderBykeys = wqg_utils::array_value_as_string(
                        $wqgData,
                        'sorting/orderby',
                        'date',
                        'trim'
                    );
                ?>

                <select id="<?= $idPrefix?>sorting-orderby" name="sorting[orderby]" class="chosen" data-placeholder="Select the field">
                    <?php foreach ( $orderByKeys as $key ): ?>
                        <option value="<?= $key ?>"
                                <?php if ($key == $selectedOrderBykeys): ?>selected<?php endif; ?>><?= $key ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Sort Dir (#order)</strong>Sorting direction<br/>
                <?php
                    $sortDirs = array('asc','desc');

                    $selectedSortDir = wqg_utils::array_value_as_string(
                        $wqgData,
                        'sorting/order',
                        'desc',
                        'trim'
                    );
                ?>

                <select id="<?= $idPrefix?>sorting-order" name="sorting[order]" class="chosen" data-placeholder="Select order">
                    <?php foreach ( $sortDirs as $key ): ?>
                        <option value="<?= $key ?>"
                                <?php if ($key == $selectedSortDir): ?>selected<?php endif; ?>><?= $key ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <?php

        $showMetaKeyBlock = in_array($selectedOrderBykeys,array('meta_value','meta_value_num'));

    ?>

    <tr id="me-anjan-wqg-tr-sorting-meta-key" style="<?= !$showMetaKeyBlock ? 'display:none;':'' ?>">
        <td>
            <label>
                <strong>Meta key (#meta_key)</strong>Meta key name<br/>
                <?php
                    $metaKeys = wqg_posts::getAllPostMetaKeys();

                    $selectedMetaKey = wqg_utils::array_value_as_string(
                        $wqgData,
                        'sorting/meta_key',
                        '',
                        'trim'
                    );
                ?>

                <select id="<?= $idPrefix?>sorting-meta-key" name="sorting[meta_key]" class="chosen" data-placeholder="Select meta key">
                    <option value=""></option>
                    <?php foreach ( $metaKeys as $key ): ?>
                        <option value="<?= $key ?>"
                                <?php if ($key == $selectedMetaKey): ?>selected<?php endif; ?>><?= $key ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

</table>