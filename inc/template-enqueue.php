<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts() {
    wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.min.css', ['owl-default'], '1.1', false );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'all', get_template_directory_uri() . '/assets/js/all.min.js', ['jquery'], '1.0', true );
    wp_enqueue_script( 'web', get_template_directory_uri() . '/assets/js/web.js',     ['all'],    '1.0', true );
}