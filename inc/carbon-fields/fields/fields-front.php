<?php
if ( !defined('ABSPATH') ) {
    die();
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Контент' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'front-page.php' )
    ->add_tab( "Заголовки", [
        Field::make( 'text', 'front-titles-first', 'Заголовок первой большой секции' ),
        Field::make( 'text', 'front-titles-second', 'Заголовок второй большой секции' ),
    ] )
    ->add_tab( "Видео", [
        Field::make( 'image',    'front-video-thumbnail', 'Превью картинка видео')->set_width(33),
        Field::make( 'text',     'front-video-link',      'Ссылка на видео YouTube')->set_width(33),
        Field::make( 'text',     'front-video-title',     'Заголовок')->set_width(33),
        Field::make( 'textarea', 'front-video-text',      'Небольшое описание'),
        
    ] );
    // ->add_tab( "Реклама", [
    //     Field::make( 'file', 'front-ad-thumbnail', 'Картинка рекламы'),
    //     Field::make( 'text', 'front-ad-link',      'Ссылка'),
    // ] ); 
