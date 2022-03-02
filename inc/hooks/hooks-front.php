<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_open', 10 );
function fxs_front_triple_columns_open( $post ) {
    echo '<section class="front-first triple__columns">
            <div class="container"> 
                <div class="triple__columns-row"> ';
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_sidebar_first', 20 );
function fxs_front_triple_columns_sidebar_first( $post ) {
    $args = [
        'posts_per_page' => 15,
        'post_type' => 'post',
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 29
            ]
        ]
    ];
    $query = new WP_Query( $args );
    ?>
    <div class="triple__columns-sidebar"> 
        <aside>
            <div class="section__title"> 
                <h3>Новости</h3>
            </div>

            <?php if ( $query->have_posts() ) :  ?>

                <div class="news__list">
                    <ul> 
                        
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                            <li><a href="<?php echo get_permalink( $query->post ); ?>"><?php the_title(); ?></a></li>

                        <?php endwhile; ?>

                    </ul>
                </div>

            <?php endif; ?>

        </aside>
    </div>
    <?php
    wp_reset_postdata();
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_content', 30 );
function fxs_front_triple_columns_content( $post ) {
    $args = [
        'posts_per_page' => 1,
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 30
            )
        )
    ];
    $big_news = new WP_Query( $args );
    ?>
    <div class="triple__columns-content">
        <div class="general_section_news">
            <div class="general_section_news-big">

                <?php 
                if ( $big_news->have_posts() ) : 

                    while ( $big_news->have_posts() ) : 

                        $big_news->the_post(); 

                        get_template_part( 'template-parts/content-news', 'big' );

                    endwhile;
                
                endif; 
                ?>

            </div>

    <?php
    wp_reset_postdata();
    
    $args = [
        'posts_per_page' => 2,
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 31
            )
        )
    ];
    $news = new WP_Query( $args );
    ?>
            <div class="general_section_news-small">
                <div class="row">
                    <?php 
                    if ( $news->have_posts() ) : 

                        while ( $news->have_posts() ) : 

                            $news->the_post(); 

                            echo '<div class="col-xl-6 general_section_news-item">';

                            get_template_part( 'template-parts/content-news', 'default' );

                            echo '</div>';

                        endwhile;
                    
                    endif; 
                    wp_reset_postdata();
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_sidebar_last_open', 37 );
function fxs_front_triple_columns_sidebar_last_open() {
    echo '<div class="triple__columns-sidebar"> 
            <aside>';
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_sidebar_last', 40 );
function fxs_front_triple_columns_sidebar_last( $post ) {

    if ( is_category() ) {
        $position = 'categories';
    } else {
        $position = 'front';
    }

    $data = Array( 
        'front-video-thumbnail' => carbon_get_post_meta( $post->ID, 'front-video-thumbnail' ),
        'front-video-link' => carbon_get_post_meta( $post->ID, 'front-video-link' ),
        'front-video-title' => carbon_get_post_meta( $post->ID, 'front-video-title' ),
        'front-video-text' => carbon_get_post_meta( $post->ID, 'front-video-text' ),

        'ad' => ad( $position ), //global_ad(),

        // 'front-ad-thumbnail' => carbon_get_post_meta( $post->ID, 'front-ad-thumbnail' ),
        // 'front-ad-link' => carbon_get_post_meta( $post->ID, 'front-ad-link' ),
    );
    
    if ( !empty($data['front-video-link']) && !empty($data['front-video-title']) && $data['front-video-thumbnail'] > 1 ) : ?>
                
        <div class="widget">
            <div class="section__title"> 
                <h3>Видео</h3>
            </div>
            <div class="widget-body"> 
                <div class="video__preview">
                    <div class="video__preview-thumbnail"> 
                        <a class="popup_video" href="<?php echo $data['front-video-link']; ?>">
                            <?php echo wp_get_attachment_image( $data['front-video-thumbnail'], 'default_news_thumbnail' ); ?>
                        </a>
                    </div>
                    <h3><?php echo $data['front-video-title']; ?></h3>
                    <p><?php echo nl2br($data['front-video-text']); ?></p>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if ( !empty($data['ad']) ) : ?>
            
        <div class="widget">
            <div class="widget-body"> 
                <div class="ad"><?php echo $data['ad']; ?></div>
            </div>
        </div>

    <?php endif; 
    
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_sidebar_last_close', 43 );
function fxs_front_triple_columns_sidebar_last_close() {
    echo '</aside>
        </div>';
}

add_action( 'fxs_front_triple_columns', 'fxs_front_triple_columns_close', 50 );
function fxs_front_triple_columns_close( $post ) {
    echo '</div>
        </div>
    </section>';
}



add_action( 'fxs_front_second', 'fxs_front_second_open_container', 5 );
function fxs_front_second_open_container( $post ) {
    echo '<div class="container">';
}

add_action( 'fxs_front_second', 'fxs_front_second_open', 10 );
function fxs_front_second_open( $post ) {
    echo '<section class="front-second">
            <div class="row front-second-row">';
}

add_action( 'fxs_front_second', 'fxs_front_second_list', 20 );
function fxs_front_second_list( $post ) {
    $args = [
        'posts_per_page' => 4,
        'post_type' => 'post',
        'offset' => 2,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 31
            )
        )
    ];
    $news = new WP_Query( $args );

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-xl-3 col-lg-4 col-sm-6 general_section_news-item">';

            get_template_part( 'template-parts/content-news', 'default' );

            echo '</div>';

        endwhile;

    endif;

    wp_reset_postdata();
}

add_action( 'fxs_front_second', 'fxs_front_second_close', 30 );
function fxs_front_second_close( $post ) {
    echo '</div>
        </section>';
}



add_action( 'fxs_front_posts_first', 'fxs_front_posts_first_open', 10 );
function fxs_front_posts_first_open( $post ) {
    $data = carbon_get_post_meta( $post->ID, 'front-titles-first' );
    
    echo '<section class="front-thirth standart_news_section">
            <div class="row">';

    if ( !empty($data) ) {
        echo '<div class="col-12">
                    <div class="section__title"> 
                        <h3>' . $data . '</h3>
                    </div>
                </div>';
    }
}

add_action( 'fxs_front_posts_first', 'fxs_front_posts_first_big', 20 );
function fxs_front_posts_first_big( $post ) {
    $args = [
        'posts_per_page' => 1,
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 32
            )
        )
    ];
    $news = new WP_Query( $args );

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-xl-6 standart_news_section-col">';

            get_template_part( 'template-parts/content-news', 'big' );

            echo '</div>';

        endwhile;

    endif;

    wp_reset_postdata();
}

add_action( 'fxs_front_posts_first', 'fxs_front_posts_first_horizontal', 20 );
function fxs_front_posts_first_horizontal( $post ) {
    $args = [
        'posts_per_page' => 3,
        'post_type' => 'post',
        'offset' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 32
            )
        )
    ];
    $news = new WP_Query( $args );

    echo '<div class="col-xl-6 standart_news_section-col">
            <div class="row">';

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-sm-12 col-6 standart_news_section-item-col"><div class="standart_news_section-item">';

            get_template_part( 'template-parts/content-news', 'horizontal' );

            echo '</div></div>';

        endwhile;

    endif;

    echo '</div></div>';

    wp_reset_postdata();
}

add_action( 'fxs_front_posts_first', 'fxs_front_posts_first_close', 40 );
function fxs_front_posts_first_close( $post ) {
    echo '</div>
        </section>';
}




add_action( 'fxs_front_posts_second', 'fxs_front_posts_second_open', 10 );
function fxs_front_posts_second_open( $post ) {
    echo '<section class="front-second">
            <div class="row front-second-row">';
}

add_action( 'fxs_front_posts_second', 'fxs_front_posts_second_list', 20 );
function fxs_front_posts_second_list( $post ) {
    $args = [
        'posts_per_page' => 4,
        'post_type' => 'post',
        'offset' => 4,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 32
            )
        )
    ];
    $news = new WP_Query( $args );

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-xl-3 col-lg-4 col-sm-6 general_section_news-item">';

            get_template_part( 'template-parts/content-news', 'default' );

            echo '</div>';

        endwhile;

    endif;

    wp_reset_postdata();
}

add_action( 'fxs_front_posts_second', 'fxs_front_posts_second_close', 30 );
function fxs_front_posts_second_close( $post ) {
    echo '</div>
        </section>';
}



add_action( 'fxs_front_posts_thirth', 'fxs_front_posts_thirth_open', 10 );
function fxs_front_posts_thirth_open( $post ) {
    $data = carbon_get_post_meta( $post->ID, 'front-titles-second' );
    
    echo '<section class="front-thirth standart_news_section">
            <div class="row">';

    if ( !empty($data) ) {
        echo '<div class="col-12">
                    <div class="section__title"> 
                        <h3>' . $data . '</h3>
                    </div>
                </div>';
    }
}

add_action( 'fxs_front_posts_thirth', 'fxs_front_posts_thirth_big', 20 );
function fxs_front_posts_thirth_big( $post ) {
    $args = [
        'posts_per_page' => 1,
        'post_type' => 'post',
        'offset' => 8,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 32
            )
        )
    ];
    $news = new WP_Query( $args );

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-xl-6 standart_news_section-col">';

            get_template_part( 'template-parts/content-news', 'big' );

            echo '</div>';

        endwhile;

    endif;

    wp_reset_postdata();
}

add_action( 'fxs_front_posts_thirth', 'fxs_front_posts_thirth_horizontal', 20 );
function fxs_front_posts_thirth_horizontal( $post ) {
    $args = [
        'posts_per_page' => 3,
        'post_type' => 'post',
        'offset' => 9,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 32
            )
        )
    ];
    $news = new WP_Query( $args );

    echo '<div class="col-xl-6 standart_news_section-col">
            <div class="row">';

    if ( $news->have_posts() ) :

        while ( $news->have_posts() ) :

            $news->the_post();

            echo '<div class="col-sm-12 col-6 standart_news_section-item-col"><div class="standart_news_section-item">';

            get_template_part( 'template-parts/content-news', 'horizontal' );

            echo '</div></div>';

        endwhile;

    endif;

    echo '</div></div>';

    wp_reset_postdata();
}

add_action( 'fxs_front_posts_thirth', 'fxs_front_posts_thirth_close', 40 );
function fxs_front_posts_thirth_close( $post ) {
    echo '</div>
        </section>';
}

add_action( 'fxs_front_posts_thirth', 'fxs_front_posts_thirth_open_container', 50 );
function fxs_front_posts_thirth_open_container( $post ) {
    echo '</div>';
}