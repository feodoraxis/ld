<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'fxs_search', 'fxs_front_second_open',  10 );
add_action( 'fxs_search', 'fxs_front_second_list',  20 );
add_action( 'fxs_search', 'fxs_front_second_close', 30 );

add_action( 'fxs_search', 'fxs_front_posts_first_open',       50 );
add_action( 'fxs_search', 'fxs_front_posts_first_big',        60 );
add_action( 'fxs_search', 'fxs_front_posts_first_horizontal', 70 );
add_action( 'fxs_search', 'fxs_front_posts_first_close',      80 );

add_action( 'fxs_search_sidebar', 'fxs_front_triple_columns_sidebar_last_open', 10 );
add_action( 'fxs_search_sidebar', 'fxs_front_triple_columns_sidebar_last', 20 );
add_action( 'fxs_search_sidebar', 'fxs_front_triple_columns_sidebar_last_close', 30 );
