<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_filter( 'script_loader_tag', 'add_defer_tag_script', 10, 3 );
function add_defer_tag_script( $tag, $handle, $source ) {
    $path = parse_url($_SERVER['REQUEST_URI']);

    if ( strripos( $path['path'], 'wp-admin/') ) {
        return $tag;
    }

    return str_replace( "'>", "' defer>", $tag );
}

require __DIR__ . '/hooks/hooks-header.php';
require __DIR__ . '/hooks/hooks-front.php';
require __DIR__ . '/hooks/hooks-footer.php';

require __DIR__ . '/hooks/hooks-category.php';
require __DIR__ . '/hooks/hooks-search.php';
require __DIR__ . '/hooks/hooks-single.php';