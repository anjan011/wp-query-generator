<?php

    $metaCompareTypes = array( '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' );

    $metaValueTypes = array('NUMERIC', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'SIGNED', 'TIME', 'UNSIGNED');

?>
<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Relation (#meta_query[relation])</strong>Meta query relation<br/>

                <?php
                    $relations = array(
                        'AND' => 'Match All',
                        'OR'  => 'Match Any',
                    );
                ?>

                <select size="1" name="meta_query[relation]">
                    <?php foreach ( $relations as $k => $v ): ?>
                        <option value="<?= $k ?>"
                                <?php if ($k == meAnjanWqg_Utils::arrayValue( $wqgData, 'meta_query/relation' )): ?>selected="selected"<?php endif; ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <div class="me-anjan-wqg-meta-query-block" id="me-anjan-wqg-meta-query-block">

            </div>

            <div style="clear: both;"></div>

            <input type="button" id="me-anjan-wqg-add-meta-query" value="Add Meta Query" class="button"/>
        </td>
    </tr>

</table>

<script type="text/javascript">
    var meAnjanWqgMetaQueryCriterias = <?= json_encode(array_values(meAnjanWqg_Utils::arrayValue($wqgData,'meta_query/queries')))?>;
</script>