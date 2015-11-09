<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Search By Keyword (#s)</strong>Search entries by a keyword<br />

                <input type="text" name="search[keyword]" value="<?= stripslashes(wqg_utils::array_value_as_string($wqgData,'search/keyword',''))?>" >
            </label>
        </td>
    </tr>
</table>