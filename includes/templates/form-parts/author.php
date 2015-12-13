<?php
    $wqg_users = meAnjanWqg_Users::getUsers(array(
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

                <select data-placeholder=" " name="author[id]" id="author_id" title="Author ID" size="1">
                    <option value=""></option>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= meAnjanWqg_Utils::selectedAttr($wqgData,'author/id',$u['id'])?> value="<?= $u['id']?>"><?= $u['name']?> [<?= $u['id']?>]</option>
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

                <select data-placeholder=" " name="author[name]" id="author_name" title="Author Name" size="1">
                    <option value=""></option>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= meAnjanWqg_Utils::selectedAttr($wqgData,'author/name',$u['name'])?> value="<?= $u['name']?>"><?= $u['name']?></option>
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


                <select data-placeholder="Select one or more author" name="author[in][]" id="author__in" title="Author ID List" size="10" multiple>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= meAnjanWqg_Utils::selectedAttr($wqgData,'author/in',$u['id'],true)?> value="<?= $u['id']?>"><?= $u['name']?> [<?= $u['id']?>]</option>
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


                <select data-placeholder="Select one or more author" name="author[not_in][]" id="author_not_in" title="Excluded Author ID List" size="10" multiple>
                    <?php if ( is_array( $wqg_users ) && count( $wqg_users ) > 0 ): ?>

                        <?php foreach ( $wqg_users as $u ): ?>
                            <option <?= meAnjanWqg_Utils::selectedAttr($wqgData,'author/not_in',$u['id'],true)?> value="<?= $u['id']?>"><?= $u['name']?> [<?= $u['id']?>]</option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </select>
            </label>
        </td>
    </tr>
</table>