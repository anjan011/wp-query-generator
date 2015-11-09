<table class="form-table">

    <tr>
        <td>
            <label>
                <strong>Relation (#tax_query[relation])</strong>Taxonomy query relation<br />

                <?php
                    $relations = array(
                        'AND' => 'Match All',
                        'OR' => 'Match Any'
                    );
                ?>

                <select size="1" name="tax[relation]">
                    <?php foreach ( $relations as $k => $v ): ?>
                        <option value="<?= $k ?>"
                                <?php if ($k == wqg_utils::__ARRAY_VALUE($wqgData,'tax/relation')): ?>selected="selected"<?php endif; ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <div class="taxonomy-query-block"></div>

            <div style="clear: both;"></div>

            <input type="button" id="me-anjan-wqg-add-taxonomy" value="Add Taxonomy" />
        </td>
    </tr>

    <tr>
        <td>
            <?php

                $res  = wqg_taxonomies::get_taxonomies();

            ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
    var meAnjanPluginsWqgTaxRules = <?= json_encode(wqg_utils::__ARRAY_VALUE($wqgData,'tax/rules'))?>;
</script>