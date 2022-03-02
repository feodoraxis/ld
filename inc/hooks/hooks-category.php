<?php
if ( !defined('ABSPATH') ) {
    die();
}

function fxs_hooks_category_run() {
    $FxsCategory = new FxsCategory( get_queried_object() );
    $FxsCategory->run();
}