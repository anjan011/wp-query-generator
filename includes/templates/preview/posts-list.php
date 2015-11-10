<?php if (isset($posts) && is_array($posts) && count($posts) > 0): ?>

    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Status</th>
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
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <span style="color: red;">No posts found!</span>
<?php endif; ?>