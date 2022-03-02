<?php
if ( !defined('ABSPATH') ) {
    die();
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Контент' )
    ->where( 'post_type', '=', 'post' )
    ->add_fields( [
        Field::make( 'textarea', 'post-preview-description', 'Превью-описание записи' ),
        Field::make( 'complex', 'post-left-list', 'Описания слева в детальной записи' )
            ->setup_labels( [
                'plural_name' => 'пункт',
                'singular_name' => 'пункт',
            ] )
            ->set_collapsed( true )
            ->add_fields( [
                Field::make( 'text', 'post-left-item-title', 'Заголовок'),
                Field::make( 'text', 'post-left-item-author', 'Автор'),
                Field::make( 'text', 'post-left-item-occ', 'Описание автора'),
            ] ),
        Field::make( 'complex', 'post-quotes-list', 'Цитаты слева' )
            ->setup_labels( [
                'plural_name' => 'цитату',
                'singular_name' => 'цитату',
            ] )
            ->set_collapsed( true )
            ->add_fields( [
                Field::make( 'textarea', 'post-quotes-item-text', 'Заголовок')->set_rows(3),
            ] ),
    ] );
