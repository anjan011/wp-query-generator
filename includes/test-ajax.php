<?php

    // Query Args
    $args = array(

       'post_type' => array('page'),
        'p' => @$_GET['post_id'],
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {

        echo '<div style="clear: both;"></div>';
        echo '<pre style="border: solid 1px #ccc;box-shadow: 2px 2px 2px #999;padding: 10px;border-radius: 10px;box-sizing: border-box;margin: 10px;word-wrap: break-word;">';
        print_r($the_query->get_posts());
        echo '</pre>';
        echo '<div style="clear: both;"></div>';

    } else {

        // no posts found

    }

    // Restore original Post Data
    wp_reset_postdata();

?>
