<?php if (isset($posts) && is_array($posts) && count($posts) > 0): ?>

    <table class="wp-list-table widefat me-anjan-wqg-privew-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Status</th>
                <th>Author</th>
                <th>Date</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $posts as $p ): ?>
            <tr>
                <td><?= $p->ID?></td>
                <td>
                    <a href="<?= get_post_permalink($p->ID)?>" target="_blank">
                        <?= htmlentities($p->post_title)?>
                    </a>
                </td>
                <td><?= htmlentities($p->post_type)?></td>
                <td><?= htmlentities($p->post_status)?></td>
                <td><?= get_the_author_meta('display_name', $p->post_author);?></td>
                <td><?= date( 'M d, Y h:i a' ,strtotime($p->post_date));?></td>
                <td><?= (int)$p->comment_count;?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <span style="color: red;">No posts found!</span>
<?php endif; ?>
