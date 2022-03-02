<?php
if ( !defined("ABSPATH") ) {
    die();
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( "Reference" )
    ->add_fields( array(
        Field::make( 'text', 'reference-title', "Заголовок" ),
        Field::make( 'rich_text', 'reference-text', "Описание" )
    ) )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>

        <div class="reference-block">
            <h4><?php echo $fields['reference-title']; ?></h4>
            <?php echo apply_filters( 'the_content', $fields['reference-text'] ); ?>
        </div>

        <?php
    } );