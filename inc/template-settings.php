<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_theme_support( 'search-form'     );
add_theme_support( 'gallery'         );
add_theme_support( 'caption'         );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
add_theme_support( 'woocommerce' );
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
add_theme_support( 'customize-selective-refresh-widgets' );
add_theme_support( 'align-wide' );
add_theme_support( 'responsive-embeds' );

register_nav_menus( Array(
    'primary' => __( 'Primary Menu' ),
) );

load_theme_textdomain( 'lyudidela', get_template_directory() . '/langs' );

add_image_size( 'big_news_thumbnail', 600, 280, true );
add_image_size( 'default_news_thumbnail', 280, 140, true );
add_image_size( 'ad-thumbnail', 280, 500, false );
add_image_size( 'journal_thumbnail', 580, 754, false );
add_image_size( 'news_detail', 600, 280, false );
add_image_size( 'person_preview', 281, 140, false );
