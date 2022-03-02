<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'fxs_main_header', 'fxs_main_header_logo', 10 );
function fxs_main_header_logo() {
    $logo = carbon_get_theme_option( 'option-header_logo' );
    echo '<div class="main__header-logo"><a href="/"><img src="' . wp_get_attachment_image_url( $logo ) . '" alt=""></a></div>';
}

add_action( 'fxs_main_header', 'fxs_main_header_sn', 20 );
function fxs_main_header_sn() {
    $sn_inst = carbon_get_theme_option( 'option-sn-inst' );
    $sn_telegram = carbon_get_theme_option( 'option-sn-telegram' );
    $sn_facebook = carbon_get_theme_option( 'option-sn-facebook' );
    $sn_twitter = carbon_get_theme_option( 'option-sn-twitter' );

    ?>
    <div class="main__header-sn">
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

add_action( 'fxs_main_header', 'fxs_main_header_search', 30 );
function fxs_main_header_search() {
    echo '<div class="main__header-search"> 
            <div class="search__form search__form-dark" id="header_search">
                <div class="search__form-input">
                    <form role="search" method="get" action="' . home_url( '/' ) . '">
                        <input type="text" value="' . get_search_query() . '" name="s" placeholder="Поиск" id="header_search_input" action="' . admin_url( 'admin-ajax.php' ) . '">
                    </form>
                </div>
                <div class="search__form-results" id="header_search_results"></div>
            </div>
        </div>';
}



add_action( 'fxs_mobile_menu', 'fxs_mobile_menu_logo', 10 );
function fxs_mobile_menu_logo() {
    $logo = carbon_get_theme_option( 'option-mobile_logo' );
    echo '<div class="mobile__menu-logo"><img src="' . wp_get_attachment_image_url( $logo ) . '" alt=""></div>';
}

add_action( 'fxs_mobile_menu', 'fxs_mobile_menu_close', 20 );
function fxs_mobile_menu_close() {
    echo '<div class="mobile__menu-close"> <span class="close" id="close_mobile_menu"></span></div>';
}



add_action( 'fxs_mobile_menu_sidebar', 'fxs_mobile_menu_sidebar_sn', 10 );
function fxs_mobile_menu_sidebar_sn() {
    $sn_inst = carbon_get_theme_option( 'option-sn-inst' );
    $sn_telegram = carbon_get_theme_option( 'option-sn-telegram' );
    $sn_facebook = carbon_get_theme_option( 'option-sn-facebook' );
    $sn_twitter = carbon_get_theme_option( 'option-sn-twitter' );

    ?>
    <div class="mobile__menu-sn">
        <div class="sn sn-white">
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

add_action( 'fxs_mobile_menu_sidebar', 'fxs_mobile_menu_sidebar_search', 20 );
function fxs_mobile_menu_sidebar_search() {
    echo '<div class="mobile__menu-search"> 
            <div class="search__form search__form-lite is-open">
                <div class="search__form-input"> 
                    <form role="search" method="get" action="' . home_url( '/' ) . '">
                        <input type="text" value="' . get_search_query() . '" name="s" placeholder="Поиск">
                    </form>
                </div>
            </div>
        </div>';
}
