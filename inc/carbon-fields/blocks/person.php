<?php
if ( !defined("ABSPATH") ) {
    die();
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( "Person" )
    ->add_fields( array(
        Field::make( 'image', 'person-photo', "Фото" )->set_width(30),
        Field::make( 'text', 'person-name', "Имя" )->set_width(70),
        Field::make( 'textarea', 'person-text', "Описание" )->set_rows(3),
    ) )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>

        <div class="person-block">
            <div class="row">
                <div class="col-md-6">
                    <?php echo wp_get_attachment_image( $fields['person-photo'], 'person_preview' ); ?>
                </div>
                <div class="col-md-6">
                    <div class="person-block-content row no-gutters align-items-end">
                        <div>
                            <b><?php echo $fields['person-name']; ?></b>
                            <p><?php echo $fields['person-text']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } );