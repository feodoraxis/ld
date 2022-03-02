<?php
if ( !defined('ABSPATH') ) die();

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', 'Настройки темы' )

    ->add_tab( 'Общие настройки', [
        Field::make( "image", 'option-header_logo', 'Лого в шапке')->set_width(33),
        Field::make( "image", 'option-mobile_logo', 'Мобильное лого')->set_width(33),
        Field::make( "image", 'option-footer_logo', 'Лого в подвале')->set_width(33),

        Field::make( "text", 'option-sn-inst', 'Instagram')->set_width(25),
        Field::make( "text", 'option-sn-telegram', 'Telegram')->set_width(25),
        Field::make( "text", 'option-sn-facebook', 'Facebook')->set_width(25),
        Field::make( "text", 'option-sn-twitter', 'Twitter')->set_width(25),
    ] )
    ->add_tab( 'Описание в футере', [
        Field::make( "text", "option-footer-about-title", 'Заголовок "об издании"' ),
        Field::make( "rich_text", "option-footer-about-text-first", "Об издании" ),

        Field::make( "rich_text", "option-footer-about-text-second", "Об издании (вторая колонка)" ),
        Field::make( "text", "option-footer-about-special_link", "Редакция, ссылка" ),

        Field::make( "text", "option-footer-contact-title", 'Заголовок "Контакты"' ),
        Field::make( "text", "option-footer-contact-email_first", 'Первый email' ),

        Field::make( "text", "option-footer-contact-special-title", 'Заголовок "Спецпроекты"' ),
        Field::make( "rich_text", "option-footer-contact-special-first", "Спецпроекты текст" ),

        Field::make( "rich_text", "option-footer-contact-last", "Последние контакты" ),
    ] )
    ->add_tab( "Реклама на главной", [
        Field::make( 'complex', 'option-front_ad-list', 'Баннеры на главной' )
            ->add_fields( [
                Field::make( 'image', 'option-front_ad-item-image', 'Баннер' ),
                Field::make( 'text', 'option-front_ad-item-link', 'Рекламная ссылка' ),
            ] )
            ->set_max( 5 )
            ->setup_labels( [
                'plural_name' => 'баннер',
                'singular_name' => 'баннер',
            ] )
            ->set_collapsed( true )
    ] )
    ->add_tab( "Реклама в категориях", [
        Field::make( 'complex', 'option-categories_ad-list', 'Баннеры на главной' )
            ->add_fields( [
                Field::make( 'image', 'option-categories_ad-item-image', 'Баннер' ),
                Field::make( 'text', 'option-categories_ad-item-link', 'Рекламная ссылка' ),
            ] )
            ->set_max( 5 )
            ->setup_labels( [
                'plural_name' => 'баннер',
                'singular_name' => 'баннер',
            ] )
            ->set_collapsed( true )
    ] )
    ->add_tab( "Реклама в записях", [
        Field::make( 'complex', 'option-single_ad-list', 'Баннеры на главной' )
            ->add_fields( [
                Field::make( 'image', 'option-single_ad-item-image', 'Баннер' ),
                Field::make( 'text', 'option-single_ad-item-link', 'Рекламная ссылка' ),
            ] )
            ->set_max( 5 )
            ->setup_labels( [
                'plural_name' => 'баннер',
                'singular_name' => 'баннер',
            ] )
            ->set_collapsed( true )
    ] );
