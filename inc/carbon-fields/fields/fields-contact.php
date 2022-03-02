<?php
if ( !defined('ABSPATH') ) {
    die();
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Информация' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'page-contact.php' )
    // ->add_tab( "Основное", [
    //     Field::make( 'text', 'contact-edition', 'Редакция, ссылка' ),
    // ] )
    ->add_tab( "Первая колонка", [
        Field::make( 'textarea', 'contact-first-title', 'Заголовок' )->set_rows(2),
        Field::make( 'textarea', 'contact-first-subtitle', 'Подзаголовок' )->set_rows(2),
        Field::make( 'complex', 'contact-first-list', 'Список' )
            ->setup_labels( [
                'plural_name' => 'пункт',
                'singular_name' => 'пункт',
            ] )
            ->set_collapsed( true )
            ->add_fields( [
                Field::make( 'text', 'contact-first-item-occ', 'Должность' )->set_width(50), 
                Field::make( 'text', 'contact-first-item-name', 'Имя' )->set_width(50), 
                // Field::make( 'rich_text', 'contact-first-item-text', 'Информация' )
            ] )
    ] )
    ->add_tab( "Вторая колонка", [
        Field::make( 'textarea', 'contact-second-title', 'Заголовок' )->set_rows(2),
        Field::make( 'textarea', 'contact-second-subtitle', 'Подзаголовок' )->set_rows(2),
        Field::make( 'complex', 'contact-second-list', 'Список' )
            ->setup_labels( [
                'plural_name' => 'пункт',
                'singular_name' => 'пункт',
            ] )
            ->set_collapsed( true )
            ->add_fields( [
                Field::make( 'text', 'contact-second-item-occ', 'Должность' )->set_width(50), 
                Field::make( 'text', 'contact-second-item-name', 'Имя' )->set_width(50), 
            ] )
    ] );