<?php
    $metaComparisonTypes = array( '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'NOT EXISTS', 'REGEXP', 'NOT REGEXP', 'RLIKE');
?>

<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Meta Key (#meta_key)</strong>Meta key name<br/>

                <select size="1" name="meta[key]" data-placeholder=" ">
                    <option></option>
                    <?php foreach ( meAnjanWqg_Posts::getAllPostMetaKeys() as $metaKey ): ?>
                    <option value="<?= $metaKey?>" <?php if ($metaKey == meAnjanWqg_Utils::arrayValue($wqgData,'meta/key')): ?>selected<?php endif; ?>><?= $metaKey?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Meta Value (#meta_value)</strong>Meta value<br/>

                <input type="text" name="meta[value]" value="<?= meAnjanWqg_Utils::arrayValue($wqgData,'meta/value','')?>"/>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Meta Value as number (#meta_value_num)</strong>Meta value as number<br/>

                <input type="text" name="meta[value_num]" value="<?= meAnjanWqg_Utils::arrayValue($wqgData,'meta/value_num','')?>"/>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Meta Value as number (#meta_value_num)</strong>Meta value as number<br/>

                <select size="1" name="meta[compare]">
                    <?php foreach ( $metaComparisonTypes as $v ): ?>
                        <option value="<?= $v ?>"
                                <?php if ($v == meAnjanWqg_Utils::arrayValue( $wqgData, 'meta/compare','=' )): ?>selected="selected"<?php endif; ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

</table>
