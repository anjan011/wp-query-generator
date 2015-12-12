
<p class="me-anjan-wqg-code-help clearfix">
     <button type="button" class="button-secondary me-anjan-wqg-btn-preview">
        Reload
    </button>
</p>

<div id="me-anjan-wqg-preview-box">
<?php
    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 11/10/15
     * Time: 5:55 PM
     */

    $args = $gen->getGeneratedArgs();

    $query = new WP_Query($args);

    $posts = $query->get_posts();

    $query->reset_postdata();

    require_once('posts-list.php');



?>
</div>
