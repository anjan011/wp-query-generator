<table class="form-table">
    <tr>
        <td>
            <label>
                <?php
                    $nopaging = wqg_utils::array_value_as_int($wqgData,'pagination/nopaging',0) > 0;
                ?>
                <input type="hidden" name="pagination[nopaging]" value="0"  />
                <input id="me-anjan-wqg-cb-nopaging" type="checkbox" name="pagination[nopaging]" value="1" <?php if ($nopaging): ?>checked<?php endif; ?> /> No Pagination
            </label>
        </td>
    </tr>




    <tbody id="me-anjan-wqg-tbody-pagination-params" style="<?= $nopaging ? 'display:none;':''?>">

        <tr>
            <td>
                <label>
                    <strong>Posts Per Page (#posts_per_page)</strong>Number of posts per page<br/>

                    <input type="text" name="pagination[posts_per_page]" value="<?= wqg_utils::array_value_as_int($wqgData,'pagination/posts_per_page',10)?>"  />
                </label>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    <strong>Paged (#paged)</strong>Page number<br/>

                    <input type="text" name="pagination[paged]" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'pagination/paged')?>"  />
                </label>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    <strong>Page (#page)</strong>Page number (For static front page)<br/>

                    <input type="text" name="pagination[page]" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'pagination/page')?>"  />
                </label>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    <strong>Offset (#offset)</strong>Offset<br/>

                    <input type="text" name="pagination[offset]" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'pagination/offset','')?>"  />
                </label>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    <strong>Posts Per Archive Page (#posts_per_archive_page)</strong>Number of posts per archive/search page<br/>

                    <input type="text" name="pagination[posts_per_archive_page]" value="<?= wqg_utils::__ARRAY_VALUE($wqgData,'pagination/posts_per_archive_page')?>"  />
                </label>
            </td>
        </tr>

        <tr>
            <td>
                <label>
                    <?php
                        $ignore_sticky_posts = wqg_utils::array_value_as_int($wqgData,'pagination/ignore_sticky_posts',0) > 0;
                    ?>
                    <input type="hidden" name="pagination[ignore_sticky_posts]" value="0"  />
                    <input type="checkbox" name="pagination[ignore_sticky_posts]" value="1" <?php if ($ignore_sticky_posts): ?>checked<?php endif; ?> /> Ignore Sticky Posts
                </label>
            </td>
        </tr>

    </tbody>

</table>