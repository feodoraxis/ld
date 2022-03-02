<?php
if ( !defined('ABSPATH') ) {
    die();
}

add_action( 'fxs_single_sidebar_left', 'fxs_single_sidebar_left_theme', 10 );
function fxs_single_sidebar_left_theme( $post ) {
    $terms_ids = wp_get_post_categories( $post->ID );
    $excludes = EXCLUDES_TERMS;

    foreach ( $terms_ids as $key => $item ) {
        if ( in_array( $item, $excludes ) ) {
            unset( $terms_ids[ $key ] );
        }
    }

    $term = get_terms( [
        'taxonomy' => 'category',
        'include' => $terms_ids
    ] )['0'];

    $data = [
        'post-left-list' => carbon_get_post_meta( $post->ID, 'post-left-list' ),
    ];

    echo '<div class="news__single-description">';


    if ( $term->name ) {
        echo '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
    }

    if ( !empty( $data['post-left-list'] ) ) {
        echo '<ul>';

        foreach ( $data['post-left-list'] as $item ) {
            echo '<li>';

            if ( !empty($item['post-left-item-title']) ) {
                echo '<b>' . $item['post-left-item-title'] . '</b>';
            }

            if ( !empty($item['post-left-item-author']) ) {
                echo '<p>' . $item['post-left-item-author'] . '</p>';
            }

            if ( !empty($item['post-left-item-occ']) ) {
                echo '<i>' . $item['post-left-item-occ'] . '</i>';
            }

            echo '</li>';
        }

        echo '</ul>';
    }
    
    echo '</div>';
}

add_action( 'fxs_single_sidebar_left', 'fxs_single_sidebar_left_quotes', 20 );
function fxs_single_sidebar_left_quotes( $post ) {
    $FxsSingle = new FxsSingle( $post );
    echo $FxsSingle->run_quotes_desctop();
}


add_action( 'fxs_single_sidebar_right', 'fxs_single_sidebar_right_quotes', 10 );
function fxs_single_sidebar_right_quotes( $post ) {
    $FxsSingle = new FxsSingle( $post );
    echo $FxsSingle->run_quotes_mobile();
}

add_action( 'fxs_single_sidebar_right', 'fxs_single_sidebar_right_ad', 20 );
function fxs_single_sidebar_right_ad( $post ) {
    echo '<div class="news__single-ad">' . ad( 'single' ) . '</div>';
}

add_action( 'fxs_single_sidebar_right', 'fxs_single_sidebar_right_popular', 30 );
function fxs_single_sidebar_right_popular( $post ) {

    $args = [
        'posts_per_page' => 3,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => 37
            )
        )
    ];

    $result = new WP_Query( $args );

    if ( $result->have_posts() ) :

        echo '<div class="news__single-popular">
                    <div class="section__title"> 
                        <h3>Самые популярные</h3>
                    </div>
                    <div class="row">';

        while ( $result->have_posts() ) :

            $result->the_post();


            echo '<div class="col-lg-12 col-6 news__single-preview__item-col"><div class="news__single-preview__item"> ';

            get_template_part( 'template-parts/content-news', 'default' );

            echo '</div></div>';

        endwhile;

        echo '</div>
            </div>';

    endif; 

    wp_reset_postdata();
}

add_action( 'fxs_single_read_more', 'fxs_single_read_more_list', 10 );
function fxs_single_read_more_list( $post ) {

    $terms_ids = wp_get_post_categories( $post->ID );

    foreach ( $terms_ids as $key => $item ) {
        if ( in_array( $item, EXCLUDES_TERMS ) ) {
            unset( $terms_ids[ $key ] );
        }
    }

    $args = [
        'posts_per_page' => 4,
        'orderby' => 'RAND',
        'post__not_in' => [$post->ID],
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $terms_ids
            )
        )
    ];

    $result = new WP_Query( $args );

    if ( $result->have_posts() ) :
            
        echo '<section class="front-second">
            <div class="row front-second-row">';

        while ( $result->have_posts() ) : $result->the_post();

            echo '<div class="col-xl-3 col-lg-4 col-sm-6 general_section_news-item">';

            get_template_part( 'template-parts/content-news', 'default' );

            echo '</div>';
        
        endwhile;
        
        echo '</div>
            </section>';

    endif;

    wp_reset_postdata();

}

add_action( 'fxs_single_second_news', 'fxs_single_second_news_index', 10 );
function fxs_single_second_news_index( $post ) {
    $FxsSingle = new FxsSingle( $post );
    $FxsSingle->second_news();
}

add_action( 'fxs_single_three_followup', 'fxs_single_three_followup_index', 10 );
function fxs_single_three_followup_index( $post ) {
    $FxsSingle = new FxsSingle( $post );
    $FxsSingle->three_followup_news();
}