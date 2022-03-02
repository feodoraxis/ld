<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'wp_ajax_'        . 'preview_search', 'preview_search' );
add_action( 'wp_ajax_nopriv_' . 'preview_search', 'preview_search' ); 
function preview_search() {

    if ( empty( $_POST['form'] ) ) {
        return false;
    }

    $s = htmlspecialchars( $_POST['form']['s'] );

    $args = [
        's' => $s,
        'post_type' => 'post',
        'posts_per_page' => 3,
    ];

    $result = new WP_Query( $args );
    $data['result'] = 'empty';

    if ( $result->have_posts() ) : 

        $data['result'] = 'success';

        while ( $result->have_posts() ) :

            $result->the_post();

            $data['list'][] = [
                'link' => get_permalink(),
                'title' => get_the_title(),
            ];

        endwhile;

    endif; 

    wp_reset_postdata();

    die( json_encode( $data ) );

}