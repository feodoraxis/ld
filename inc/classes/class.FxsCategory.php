<?php
if ( !defined('ABSPATH') ) {
    die();
}

class FxsCategory {

    private $posts_per_page = 8;
    private $current_category;
    private $subcategories = [];

    public function __construct($current_category) {

        $this->current_category = $current_category;

        $this->set_subcategories();

        if ( empty( $this->subcategories ) ) {
            $this->posts_per_page++;
        }
    }

    public function run() {
        add_action( 'fxs_category', [ $this, 'first_section_open' ],  10 );
        add_action( 'fxs_category', [ $this, 'left_section_open' ],   20 );
        add_action( 'fxs_category', [ $this, 'list_subcategories' ],  30 );
        add_action( 'fxs_category', [ $this, 'list_news' ],           40 );
        add_action( 'fxs_category', [ $this, 'left_section_close' ],  50 );
        add_action( 'fxs_category', [ $this, 'sidebar_open' ],        60 );
        add_action( 'fxs_category', [ $this, 'sidebar_data' ],        70 );
        add_action( 'fxs_category', [ $this, 'sidebar_close' ],       80 );
        add_action( 'fxs_category', [ $this, 'first_section_close' ], 90 );

        add_action( 'fxs_category', [ $this, 'continue_section_container_open' ],  97 );
        add_action( 'fxs_category', [ $this, 'continue_section_open' ],            100 );
        add_action( 'fxs_category', [ $this, 'continue_section_content' ],         110 );
        add_action( 'fxs_category', [ $this, 'continue_section_close' ],           120 );
        add_action( 'fxs_category', [ $this, 'continue_section_container_close' ], 130 );
    }

    public function first_section_open() {
        echo '<section class="double__columns">
            <div class="container"> 
                <div class="row">';
    }

    public function left_section_open() {
        echo '<div class="col-xl-9 col-lg-8">
            <div class="row">';
    }

    public function list_subcategories() {

        if ( empty( $this->subcategories ) ) {
            return;
        }

        echo '<div class="col-xl-4 col-6 double__columns-item">
                <div class="subcategories">
                    <div class="subcategories-button"> 
                        <button id="subcategories_button">Категории</button>
                    </div>
                    <ul class="subcategories-list" id="subcategories_list"> ';

        foreach ( $this->subcategories as $item ) :

            echo '<li><a href="' . get_term_link( $item, 'category' ) . '">' . $item->name . '</a></li>';

        endforeach;

        echo '</ul>
            </div>
        </div>';
    }

    public function list_news() {

        global $wp_query;

        $args = array_merge( $wp_query->query_vars, [
            'post_type' => 'post',
            'posts_per_page' => $this->posts_per_page,
        ] );

        query_posts( $args );

        if ( have_posts() ) :
            
            while ( have_posts() ) :

                the_post();

                echo '<div class="col-xl-4 col-6 double__columns-item">';

                get_template_part( 'template-parts/content-news', 'default' );

                echo '</div>';

            endwhile;

        endif;
        
        wp_reset_postdata();
    }

    public function left_section_close() {
        echo '</div></div>';
    }

    public function sidebar_open() {
        echo '<div class="col-xl-3 col-lg-4 double__columns-sidebar">
            <aside>';
    }

    public function sidebar_data() {
        fxs_front_triple_columns_sidebar_last( get_post( get_option('page_on_front') ) );
    }

    public function sidebar_close() {
        echo '</div>
            </div>
        </section>';
    }

    // Start second
    public function continue_section_container_open() { 
        echo '<div class="container">';
    }

    public function continue_section_open() {
        echo '<section class="front-second">
                <div class="row front-second-row">';
    }

    public function continue_section_content() {

        $args = [
            'post_type' => 'post',
            'offset' => $this->posts_per_page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'id',
                    'terms'    => $this->current_category->parent
                )
            ),
            'posts_per_page' => 12,
        ];
        $i = 0;

        $result = new WP_Query( $args );

        if ( $result->have_posts() ) :

            while ( $result->have_posts() ) :

                $i++;

                $result->the_post();

                echo '<div class="col-xl-3 col-lg-4 col-sm-6 general_section_news-item">';

                get_template_part( 'template-parts/content-news', 'default' );

                echo '</div>';

                if ( $i == 4 ) {
                    $this->continue_section_close();
                    $this->continue_section_open();
                    $i = 0;
                }

            endwhile;

        endif; 

        wp_reset_postdata();
    }

    public function continue_section_close() {
        echo '</div>
            </section>';
    }

    public function continue_section_container_close() { 
        echo '</div>';
    }

    private function set_subcategories() {

        if ( $this->current_category->term_id ) {

            $this->subcategories = get_terms([
                'taxonomy' => 'category',
                'parent' => $this->current_category->term_id
            ]);
        
        }
    }
}