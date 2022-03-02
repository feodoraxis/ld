<?php
if ( !defined("ABSPATH") ) {
    die();
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( "List" )
    ->add_fields( array(
        Field::make( 'text', 'list-title', "Заголовок" ),
        Field::make( 'complex', 'list-list', "Список" )
            ->add_fields([
                Field::make( "text", "list-item-text", 'Текст' )
            ])
            ->setup_labels( [
                'plural_name' => 'пункт',
                'singular_name' => 'пункт',
            ] ),
    ) )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

        if ( !empty( $fields['list-list'] ) ) : ?>

        <div class="list-block">
            <h4><?php echo $fields['list-title']; ?></h4>
            <ul>

                <?php foreach ( $fields['list-list'] as $item ) : ?>

                    <li><?php echo $item['list-item-text']; ?></li>

                <?php endforeach; ?>

            </ul>
        </div>

        <?php endif;
    } );