<?php

    // Query Args
    $args = array(

       'post_type' => array('any'),
        'date_query' => array(
            'relation' => 'AND',
            array(
                'year' => 2010,


                'compare' => '>'
            ),

            array(
                'year' => 2015,


                'compare' => '<'
            ),

            /*array(
                'year' => 2015,
                'compare' => '<='
            ),
            'inclusive' => true*/
        ),
        'nopaging' => true,
        'order' => 'asc',
        'orderby' => 'date'
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {

        foreach($the_query->get_posts() as $p) {

            echo formattedDate($p->post_date,'M d, Y h:i a [W]').'<br>';

        }

    } else {

        // no posts found

    }

    echo '<br><br><br>';

    echo $the_query->request;

    // Restore original Post Data
    wp_reset_postdata();
