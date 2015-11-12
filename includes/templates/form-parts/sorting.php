<table class="form-table">

    <tr>
        <td>
            <label>
                <strong>Sort Direction (#order)</strong> Sorting Direction<br/>
                <?php
                    $orderByKeys = wqg_posts::getPostOrderByFields();

                    $selectedorderBykeys = wqg_utils::array_value_as_string(
                        $wqgData,
                        'sorting/orderby',
                        'date',
                        'trim'
                    );
                ?>

                <select id="<?= $idPrefix?>sorting-orderby" name="sorting[orderby]" class="chosen" data-placeholder="Select the field">
                    <?php foreach ( $orderByKeys as $key ): ?>
                        <option value="<?= $key ?>"
                                <?php if ($key == $selectedorderBykeys): ?>selected<?php endif; ?>><?= $key ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Sort By (#orderby)</strong>Order By Field<br/>
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
</table>