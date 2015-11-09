<?php
    $wqg_users = wqg_users::get_users(array(
        'fields' => array(
            "u.ID as 'id'",
            "u.user_nicename as 'name'"
        )
    ));
?>

<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Author ID (#author)</strong>Get entries by selected author id<br />

                <select name="author[id]" id="author_id" title="Author ID" size="1">
                    <option value="">~ Select ~</option>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= wqg_utils::selected_attr($wqgData,'author/id',$u['id'])?> value="<?= $u['id']?>"><?= $u['name']?></option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </select>
            </label>
        </td>
    </tr>
    <tr>
        <td>
            <label>

                <strong>Author Name (#author_name)</strong>Get entries by selected author name (using user_nicename)<br />

                <select name="author[name]" id="author_name" title="Author Name" size="1">
                    <option value="">~ Select ~</option>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= wqg_utils::selected_attr($wqgData,'author/name',$u['name'])?> value="<?= $u['name']?>"><?= $u['name']?></option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </select>
            </label>

        </td>
    </tr>
    <tr>
        <td>
            <label>
                <strong>Author ID List (#author_in)</strong>Get entries by selected authors (using user_nicename)<br />


                <select name="author[in][]" id="author__in" title="Author ID List" size="10" multiple>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= wqg_utils::selected_attr($wqgData,'author/in',$u['id'],true)?> value="<?= $u['id']?>"><?= $u['name']?></option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </select>
            </label>
        </td>
    </tr>
    <tr>
        <td>
            <label>
                <strong>Exclude Author ID List (#author__not_in)</strong>Exclude posts from selected authors<br />


                <select name="author[not_in][]" id="author_not_in" title="Excluded Author ID List" size="10" multiple>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= wqg_utils::selected_attr($wqgData,'author/not_in',$u['id'],true)?> value="<?= $u['id']?>"><?= $u['name']?></option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </select>
            </label>
        </td>
    </tr>
</table>