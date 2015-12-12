<table class="form-table">
    <tr>
        <td>
            <label>
                <strong>Year (#year)</strong>Entries posted in the year<br />

                <input type="text" name="date[year]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/year',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Month (#monthnum)</strong>Posted in the month<br />

                <input type="text" name="date[monthnum]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/monthnum',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Week (#week)</strong>Posted in the week<br />

                <input type="text" name="date[week]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/week',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Day (#day)</strong>Posted in the day<br />

                <input type="text" name="date[day]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/day',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Hour (#hour)</strong>Posted in the hour<br />

                <input type="text" name="date[hour]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/hour',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Minute (#minute)</strong>Posted in the minute<br />

                <input type="text" name="date[minute]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/minute',''))?>" >
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label>
                <strong>Second (#second)</strong>Posted in the second<br />

                <input type="text" name="date[second]" value="<?= stripslashes(meAnjanWqg_Utils::arrayValueAsString($wqgData,'date/second',''))?>" >
            </label>
        </td>
    </tr>

</table>