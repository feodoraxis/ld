<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'fxs_main_footer', 'fxs_main_footer_sect_first_open', 10 );
function fxs_main_footer_sect_first_open() {
    echo '<div class="col-lg-3 col-md-4">
            <div class="main__footer-first">';
}

add_action( 'fxs_main_footer', 'fxs_main_footer_logo', 20 );
function fxs_main_footer_logo() {
    $logo = carbon_get_theme_option( 'option-footer_logo' );
    echo '<div class="main__footer-logo">
            <div class="main__footer_logo"><img src="' . wp_get_attachment_image_url( $logo ) . '" alt=""></div>
        </div>';
}

add_action( 'fxs_main_footer', 'fxs_main_footer_sn', 30 );
function fxs_main_footer_sn() {
    $sn_inst = carbon_get_theme_option( 'option-sn-inst' );
    $sn_telegram = carbon_get_theme_option( 'option-sn-telegram' );
    $sn_facebook = carbon_get_theme_option( 'option-sn-facebook' );
    $sn_twitter = carbon_get_theme_option( 'option-sn-twitter' );

    ?>
    <div class="main__footer-sn">
        <div class="sn">
            <ul> 
                <li><a class="inst" href="<?php echo $sn_inst; ?>"> </a></li>
                <li><a class="telegram" href="<?php echo $sn_telegram; ?>"> </a></li>
                <li><a class="facebook" href="<?php echo $sn_facebook; ?>"> </a></li>
                <li><a class="twitter" href="<?php echo $sn_twitter; ?>"> </a></li>
            </ul>
        </div>
    </div>
    <?php
}

add_action( 'fxs_main_footer', 'fxs_main_footer_sect_first_close', 40 );
function fxs_main_footer_sect_first_close() {
    echo '</div></div>';
}

add_action( 'fxs_main_footer', 'fxs_main_footer_about', 50 );
function fxs_main_footer_about() {
    $data = [
        'option-footer-about-title' => carbon_get_theme_option( 'option-footer-about-title' ),
        'option-footer-about-text-first' => carbon_get_theme_option( 'option-footer-about-text-first' ),
    ];

    echo '<div class="col-lg-3 col-md-8">
            <div class="main__footer-title">
                <h5>' . $data['option-footer-about-title'] . '</h5>
            </div>
            ' . apply_filters( 'the_content', $data['option-footer-about-text-first'] ) . '
        </div>';
}

add_action( 'fxs_main_footer', 'fxs_main_footer_about_second', 60 );
function fxs_main_footer_about_second() {
    $data = [
        'option-footer-about-text-second' => carbon_get_theme_option( 'option-footer-about-text-second' ),
        'option-footer-about-special_link' => carbon_get_theme_option( 'option-footer-about-special_link' ),
    ];

    echo '<div class="col-lg-3 col-md-6">
            <div class="main__footer-second_description">
                ' . apply_filters( 'the_content', $data['option-footer-about-text-second'] ) . '
                <div class="main__footer-special_link"><div class="special_link"><a href="' . $data['option-footer-about-special_link'] . '">Редакция</a></div></div>
                <div class="main__footer-age"><img src="/wp-content/themes/generatepress-child/assets/img/age.svg" alt=""></div>
            </div>
        </div>';
}

add_action( 'fxs_main_footer', 'fxs_main_footer_contact', 70 );
function fxs_main_footer_contact() {
    $data = [
        'option-footer-contact-title' => carbon_get_theme_option( 'option-footer-contact-title' ),
        'option-footer-contact-email_first' => carbon_get_theme_option( 'option-footer-contact-email_first' ),

        'option-footer-contact-special-title' => carbon_get_theme_option( 'option-footer-contact-special-title' ),
        'option-footer-contact-special-first' => carbon_get_theme_option( 'option-footer-contact-special-first' ),

        'option-footer-contact-last' => carbon_get_theme_option( 'option-footer-contact-last' ),
    ];

    echo '<div class="col-lg-3 col-md-6">
            <div class="main__footer-contact">
                <h5>' . $data['option-footer-contact-title'] . '</h5>
                <a href="mailto:' . $data['option-footer-contact-email_first'] . '">' . $data['option-footer-contact-email_first'] . '</a>
            </div>
            <div class="main__footer-contact">
                <h5>' . $data['option-footer-contact-special-title'] . '</h5>
                ' . apply_filters( 'the_content', $data['option-footer-contact-special-first'] ) . '
            </div>
            <div class="main__footer-contact">
                ' . apply_filters( 'the_content', $data['option-footer-contact-last'] ) . '
            </div>
        </div>';
}