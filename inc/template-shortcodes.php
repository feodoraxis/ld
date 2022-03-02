<?php
if ( !defined("ABSPATH") ) {
    die();
}

add_shortcode( "post_person", function( $atts ) {
    if ( $_REQUEST['REQUEST_METHOD'] !== 'POST' ) {
        ob_start();

        $atts = shortcode_atts( array(
            'id' => '',
        ), $atts );

        if ( intval( $atts['id'] < 2 ) ) {
            return false;
        }

        $post = get_post( $atts['id'] );

        ?>
        
        <div class="person-block">
            <div class="row">
                <div class="col-md-6">
                    <?php echo get_the_post_thumbnail( $post->ID, 'person_preview' ); ?>
                </div>
                <div class="col-md-6">
                    <div class="person-block-content row no-gutters align-items-end">
                        <div>
                            <b><?php echo $post->post_title; ?></b>
                            <p><?php echo nl2br($post->post_content); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }
});