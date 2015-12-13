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
                                <?php if ($k == meAnjanWqg_Utils::arrayValue($wqgData,'tax/relation')): ?>selected="selected"<?php endif; ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <div class="me-anjan-wqg-tax-query-block"></div>

            <div style="clear: both;"></div>

            <input type="button" id="me-anjan-wqg-add-taxonomy" value="Add Taxonomy" class="button" />
        </td>
    </tr>

    <tr>
        <td>
            <?php

                $res  = meAnjanWqg_Taxonomies::getTaxonomies();

            ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
    var meAnjanPluginsWqgTaxRules = <?= json_encode(meAnjanWqg_Utils::arrayValue($wqgData,'tax/rules'))?>;
</script>