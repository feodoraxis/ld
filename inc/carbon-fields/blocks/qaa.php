<?php
if ( !defined("ABSPATH") ) {
    die();
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( "Questions" )
    ->add_fields( array(

        Field::make( "complex", 'qaa-list', 'Вопросы и ответы' )
            ->add_fields([
                Field::make( "text", 'qaa-item-question', 'Вопрос' ),
                Field::make( "textarea", 'qaa-item-answer', 'Ответ' )
            ])
            ->setup_labels( [
                'plural_name' => 'вопрос',
                'singular_name' => 'вопрос',
            ] ),
    ) )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

        if ( !empty($fields['qaa-list']) ) : ?>

        <div class="qaa-block">

            <?php foreach ( $fields['qaa-list'] as $item ) : ?>

                <div class="qaa-item">
                    <h4>— <?php echo $item['qaa-item-question']; ?></h4>
                    <p>— <?php echo $item['qaa-item-answer']; ?></p>
                </div>

            <?php endforeach; ?>

        </div>

        <?php endif;
    } );