<?php
    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 11/17/15
     * Time: 5:49 PM
     */

    $criteriaData = wqg_utils::array_value_as_array($wqgData,'date_query/criteria',array());

    $criteriaData = array_values($criteriaData); // to force json array

    $dateCompareOperators = array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );

?>

<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Relation (#date_query/relation)</strong>Match all or match any?<br />

                <?php
                    $dateQueryRelations = array('and','or');

                    $selectedRelation = wqg_utils::array_value_as_string(
                        $wqgData,
                        'date_query/relation',
                        'and',
                        'trim'
                    );
                ?>

                <select id="<?= $idPrefix?>date-query-relation" name="date_query[relation]" class="chosen" data-placeholder="Select relation">
                    <?php foreach ( $dateQueryRelations as $key ): ?>
                        <option value="<?= $key ?>"
                                <?php if ($key == $selectedRelation): ?>selected<?php endif; ?>><?= $key ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
        </td>
    </tr>

    <tr>
        <td>
            <input type="button" id="<?= $idPrefix?>add-date-criteria-box" value="Add date criteria" />

            <div id="<?= $idPrefix?>date-criteria-container" class="clearfix"></div>

        </td>
    </tr>

</table>

<script>
    var meAnjanWqgDateQueryCriterias = <?= json_encode($criteriaData)?>;
</script>

