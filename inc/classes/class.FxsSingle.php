<?php
if ( !defined('ABSPATH') ) {
    die();
}

class FxsSingle {

    private $quotes = [];
    private $post;
    private $next_post = null;

    public function __construct( $post ) {

        $show_next_posts = true;
        
        $this->set_posts_quotes( $post );
        $this->post = $post;

        foreach ( get_the_category( $this->post ) as $item ) {
            if ( $item->term_id !== 29 ) {
                $show_next_posts = false;
            }
        }

        if ( $show_next_posts == true ) {
            $this->set_next_post();
        } else {
            $this->next_post = false;
        }
    }

    public function second_news( bool $show = true ) {
        if ( $this->next_post == false ) {
            return false;
        }

        ob_start();

        echo '<section class="news__single-second">
                <div class="row">
                    <div class="col-lg-4">  
                        <div class="news__single-sidebar news__single-sidebar-first">
                            <aside>';

        $this->show_left_sidebar_second_news();

        echo '</aside>
            </div>
        </div>
        <div class="col-lg-8">';

        $this->show_second_news_content();

        echo '</div>
            </div>
        </section>';

        $out = ob_get_clean();

        if ( $show === true ) {
            echo $out;
        } else {
            return $out;
        }
    }

    public function three_followup_news() {

        $out = '';

        $html_open = '<section class="news__single">
                    <div class="row">
                        <div class="col-lg-9">';

        $html_close = '</div></div></section>';

        for ( $i = 0; $i < 3; $i++ ) {
            $this->post = $this->next_post;
            $this->next_post = null;

            $this->set_next_post();
            $result = $this->second_news( false );

            if ( $result === false ) {
                $i = 3;
            } else {
                $out .= $html_open . $result . $html_close;
            }
        }

        if ( $out == '' ) {
            return;    
        }

        echo $out;
    }

    private function show_second_news_content() {
        if ( $this->next_post == false ) {
            return;
        }

        global $post;

        $post = $this->next_post;
        setup_postdata( $this->next_post );

        $post_thumbnail = get_the_post_thumbnail( get_the_ID(), 'news_detail' );
        if ( !empty( trim( $post_thumbnail ) ) ) : ?>
            
            <div class="news__single-thumbnail">
                <?php echo $post_thumbnail; ?>
            </div>

        <?php endif; ?>
        <h1><?php the_title(); ?></h1>
        <?php 
        if ( $preview_text = carbon_get_post_meta( get_the_ID(), 'post-preview-description' ) ) {
            echo '<div class="news__single-subtitle"><p>' . $preview_text . '</p></div>';
        }
        ?>
        <div class="news__single-content"><?php the_content(); ?></div>
        <?php
        wp_reset_postdata();
    }

    public function show_left_sidebar_second_news() { //Сайдбар второй новости
        if ( $this->next_post == false ) {
            return;
        }

        $this->set_posts_quotes( $this->next_post );

        fxs_single_sidebar_left_theme( $this->next_post );
        $this->run_quotes_desctop();
    }

    public function run_quotes_desctop() {
        if ( empty($this->quotes) ) {
            return;
        }

        $out = '';

        $out .= $this->quotes_open_desctop();
        $out .= $this->quotes();
        $out .= $this->quotes_close();

        return $out;
    }

    public function run_quotes_mobile() {
        if ( empty($this->quotes) ) {
            return;
        }

        $out = '';

        $out .= $this->quotes_open_mobile();
        $out .= $this->quotes();
        $out .= $this->quotes_close();

        return $out;
    }

    private function quotes_open_desctop() {
        return '<div class="news__single-quotes news__single-quotes-desctop">';
    }

    private function quotes_open_mobile() {
        return '<div class="news__single-quotes news__single-quotes-mobile">';
    }

    private function quotes() {

        $out = '';

        foreach ( $this->quotes as $item ) {
            $out .= '<div class="news__single-quote"><p>' . nl2br($item['post-quotes-item-text']) . '</p></div>';
        }

        return $out;
    }

    private function quotes_close() {
        return '</div>';
    }

    private function set_posts_quotes( object $post_object ) {
        $this->quotes = carbon_get_post_meta( $post_object->ID, 'post-quotes-list' );
    }

    private function set_next_post() {
        if ( $this->next_post === null ) {
            $this->next_post = $this->get_next_post( $this->post ) ?? false;
        } else {
            return false;
        }
    }

    /**
     * Этот метод -- копия функции get_next_post() из ядра WP. Пришлось копировать, т.к. было критично передвать
     * объект нужной записи в параметры метода, а не брать объект из глобалки.
     * 
     * ВАЖНО! При обновлении до новых версий системы, ОБЯЗАТЕЛЬНО выполнить следующие действия:
     * 1. Проверить, не появилось-ли в API WP функции, позволяющей получить следующую запись после переданного объекта 
     *    записи в парамер функции. Если появилось -- везде заменить этот метод на новую функцию и удлаить этот метод
     *    с комментарием.
     * 2. Если не появилось -- проверять оригинальную функцию get_next_post(). Все изменения копировать сюда, чтобы 
     *    метод продолжал работать, как должен -- с передачей в него объекта, а не исопльзованием объекта из гллобалки.
     */
    private function get_next_post( $post, $in_same_term = true, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
        global $wpdb;

        if ( ! $post || ! taxonomy_exists( $taxonomy ) ) {
            return null;
        }

        $current_post_date = $post->post_date;

        $join     = '';
        $where    = '';
        $adjacent = $previous ? 'previous' : 'next';

        if ( ! empty( $excluded_terms ) && ! is_array( $excluded_terms ) ) {
            // Back-compat, $excluded_terms used to be $excluded_categories with IDs separated by " and ".
            if ( false !== strpos( $excluded_terms, ' and ' ) ) {
                _deprecated_argument(
                    __FUNCTION__,
                    '3.3.0',
                    sprintf(
                        /* translators: %s: The word 'and'. */
                        __( 'Use commas instead of %s to separate excluded terms.' ),
                        "'and'"
                    )
                );
                $excluded_terms = explode( ' and ', $excluded_terms );
            } else {
                $excluded_terms = explode( ',', $excluded_terms );
            }

            $excluded_terms = array_map( 'intval', $excluded_terms );
        }

        /**
         * Filters the IDs of terms excluded from adjacent post queries.
         *
         * The dynamic portion of the hook name, `$adjacent`, refers to the type
         * of adjacency, 'next' or 'previous'.
         *
         * Possible hook names include:
         *
         *  - `get_next_post_excluded_terms`
         *  - `get_previous_post_excluded_terms`
         *
         * @since 4.4.0
         *
         * @param array|string $excluded_terms Array of excluded term IDs. Empty string if none were provided.
         */
        $excluded_terms = apply_filters( "get_{$adjacent}_post_excluded_terms", $excluded_terms );

        if ( $in_same_term || ! empty( $excluded_terms ) ) {
            if ( $in_same_term ) {
                $join  .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
                $where .= $wpdb->prepare( 'AND tt.taxonomy = %s', $taxonomy );

                if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
                    return '';
                }
                $term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

                // Remove any exclusions from the term array to include.
                $term_array = array_diff( $term_array, (array) $excluded_terms );
                $term_array = array_map( 'intval', $term_array );

                if ( ! $term_array || is_wp_error( $term_array ) ) {
                    return '';
                }

                $where .= ' AND tt.term_id IN (' . implode( ',', $term_array ) . ')';
            }

            if ( ! empty( $excluded_terms ) ) {
                $where .= " AND p.ID NOT IN ( SELECT tr.object_id FROM $wpdb->term_relationships tr LEFT JOIN $wpdb->term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) WHERE tt.term_id IN (" . implode( ',', array_map( 'intval', $excluded_terms ) ) . ') )';
            }
        }

        // 'post_status' clause depends on the current user.
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();

            $post_type_object = get_post_type_object( $post->post_type );
            if ( empty( $post_type_object ) ) {
                $post_type_cap    = $post->post_type;
                $read_private_cap = 'read_private_' . $post_type_cap . 's';
            } else {
                $read_private_cap = $post_type_object->cap->read_private_posts;
            }

            /*
            * Results should include private posts belonging to the current user, or private posts where the
            * current user has the 'read_private_posts' cap.
            */
            $private_states = get_post_stati( array( 'private' => true ) );
            $where         .= " AND ( p.post_status = 'publish'";
            foreach ( (array) $private_states as $state ) {
                if ( current_user_can( $read_private_cap ) ) {
                    $where .= $wpdb->prepare( ' OR p.post_status = %s', $state );
                } else {
                    $where .= $wpdb->prepare( ' OR (p.post_author = %d AND p.post_status = %s)', $user_id, $state );
                }
            }
            $where .= ' )';
        } else {
            $where .= " AND p.post_status = 'publish'";
        }

        $op    = $previous ? '<' : '>';
        $order = $previous ? 'DESC' : 'ASC';

        /**
         * Filters the JOIN clause in the SQL for an adjacent post query.
         *
         * The dynamic portion of the hook name, `$adjacent`, refers to the type
         * of adjacency, 'next' or 'previous'.
         *
         * Possible hook names include:
         *
         *  - `get_next_post_join`
         *  - `get_previous_post_join`
         *
         * @since 2.5.0
         * @since 4.4.0 Added the `$taxonomy` and `$post` parameters.
         *
         * @param string  $join           The JOIN clause in the SQL.
         * @param bool    $in_same_term   Whether post should be in a same taxonomy term.
         * @param array   $excluded_terms Array of excluded term IDs.
         * @param string  $taxonomy       Taxonomy. Used to identify the term used when `$in_same_term` is true.
         * @param WP_Post $post           WP_Post object.
         */
        $join = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_term, $excluded_terms, $taxonomy, $post );

        /**
         * Filters the WHERE clause in the SQL for an adjacent post query.
         *
         * The dynamic portion of the hook name, `$adjacent`, refers to the type
         * of adjacency, 'next' or 'previous'.
         *
         * Possible hook names include:
         *
         *  - `get_next_post_where`
         *  - `get_previous_post_where`
         *
         * @since 2.5.0
         * @since 4.4.0 Added the `$taxonomy` and `$post` parameters.
         *
         * @param string  $where          The `WHERE` clause in the SQL.
         * @param bool    $in_same_term   Whether post should be in a same taxonomy term.
         * @param array   $excluded_terms Array of excluded term IDs.
         * @param string  $taxonomy       Taxonomy. Used to identify the term used when `$in_same_term` is true.
         * @param WP_Post $post           WP_Post object.
         */
        $where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s $where", $current_post_date, $post->post_type ), $in_same_term, $excluded_terms, $taxonomy, $post );

        /**
         * Filters the ORDER BY clause in the SQL for an adjacent post query.
         *
         * The dynamic portion of the hook name, `$adjacent`, refers to the type
         * of adjacency, 'next' or 'previous'.
         *
         * Possible hook names include:
         *
         *  - `get_next_post_sort`
         *  - `get_previous_post_sort`
         *
         * @since 2.5.0
         * @since 4.4.0 Added the `$post` parameter.
         * @since 4.9.0 Added the `$order` parameter.
         *
         * @param string $order_by The `ORDER BY` clause in the SQL.
         * @param WP_Post $post    WP_Post object.
         * @param string  $order   Sort order. 'DESC' for previous post, 'ASC' for next.
         */
        $sort = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1", $post, $order );

        $query     = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort";
        $query_key = 'adjacent_post_' . md5( $query );
        $result    = wp_cache_get( $query_key, 'counts' );
        if ( false !== $result ) {
            if ( $result ) {
                $result = get_post( $result );
            }
            return $result;
        }

        $result = $wpdb->get_var( $query );
        if ( null === $result ) {
            $result = '';
        }

        wp_cache_set( $query_key, $result, 'counts' );

        if ( $result ) {
            $result = get_post( $result );
        }

        return $result;
    }

}