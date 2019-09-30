<?php
//Declare wp-admin url
add_action( 'wp_head', 'splash_ajaxurl' );

function splash_ajaxurl() { ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
        var stm_cf7_preloader = '<?php echo esc_url(get_template_directory_uri() . '/assets/images/map-pin.png') ?>';
    </script>
<?php }

// Event Sign up form
if ( ! function_exists( 'splash_donate_money' ) ) {
    function splash_donate_money() {
        // Get event details
        $json           = array();
        $json['errors'] = array();

        $_POST['donor']['id'] = filter_var( $_POST['donor']['id'], FILTER_VALIDATE_INT );

        if ( empty( $_POST['donor']['id'] ) ) {
            return false;
        }

        if ( ! filter_var( $_POST['donor']['name'], FILTER_SANITIZE_STRING ) ) {
            $json['errors']['name'] = true;
        }
        if ( ! is_email( $_POST['donor']['email'] ) ) {
            $json['errors']['email'] = true;
        }
        if ( ! is_numeric( $_POST['donor']['phone'] ) ) {
            $json['errors']['phone'] = true;
        }
        if ( ! filter_var( $_POST['donor']['message'], FILTER_SANITIZE_STRING ) ) {
            $json['errors']['message'] = true;
        }
        if ( ! filter_var( $_POST['donor']['amount'], FILTER_VALIDATE_INT ) ) {
            $json['errors']['amount'] = true;
        }

        if ( empty( $json['errors'] ) ) {

            $participant_data['post_title']   = $_POST['donor']['name'];
            $participant_data['post_type']    = 'donor';
            $participant_data['post_status']  = 'draft';
            $participant_data['post_excerpt'] = $_POST['donor']['message'];
            $participant_id                   = wp_insert_post( $participant_data );
            update_post_meta( $participant_id, 'donor_email', $_POST['donor']['email'] );
            update_post_meta( $participant_id, 'donor_phone', $_POST['donor']['phone'] );
            update_post_meta( $participant_id, 'donor_event', $_POST['donor']['id'] );
            update_post_meta( $participant_id, 'donor_amount', $_POST['donor']['amount'] );

            $items                = array();
            $items['item_name']   = get_the_title( $_POST['donor']['id'] );
            $items['item_number'] = $_POST['donor']['id'];
            $items['amount']      = $_POST['donor']['amount'];
            $items                = http_build_query( $items );

            $mode = get_theme_mod( 'paypal_mode', 'sandbox' );
            $url  = ( $mode == 'live' ) ? 'www.paypal.com' : 'www.sandbox.paypal.com';

            $redirect_url = '';

            $redirect_url .= 'https://' . $url;
            $redirect_url .= '/cgi-bin/webscr?cmd=_xclick&business=';
            $redirect_url .= get_theme_mod( 'paypal_email' );
            $redirect_url .= '&' . $items;
            $redirect_url .= '&no_shipping=1&no_note=1&currency_code=' . get_theme_mod( 'paypal_currency', 'USD' );
            $redirect_url .= '&bn=PP%2dBuyNowBF&charset=UTF%2d8&invoice=' . $participant_id;
            $redirect_url .= '&return=' . home_url('/') . '&rm=2&notify_url=' . home_url('/');

            add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

            $headers[] = 'From: ' . get_bloginfo( 'blogname' ) . ' <' . get_bloginfo( 'admin_email' ) . '>';

            wp_mail( get_bloginfo( 'admin_email' ), esc_html__( 'New donation', 'splash' ), esc_html__( 'New donation, please check it.', 'splash' ), $headers );

            remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

            $json['redirect_url'] = $redirect_url;

            $json['success'] = esc_html__( 'Redirecting to Paypal.', 'splash' );
        }

        echo json_encode( $json );
        exit;
    }
}

add_action( 'wp_ajax_splash_donate_money', 'splash_donate_money' );
add_action( 'wp_ajax_nopriv_splash_donate_money', 'splash_donate_money' );


if ( ! function_exists( 'splash_load_media' ) ) {
    function splash_load_media() {
        global $media_style;
        $json = array();

        $disableMasonry = (is_layout("baseball")) ? true : false;

        $category = sanitize_text_field( $_GET['category'] );
        $page     = intval( $_GET['page'] );
        $load_by  = intval( $_GET['load'] );

        /*SIDEBAR SETTINGS*/
        $sidebar_settings = splash_get_sidebar_settings( 'media_sidebar', 'media_sidebar_position', 'no_sidebar', 'right' );
        $sidebar_id       = $sidebar_settings['id'];

        $sidebar_settings_position = 'none';

        if ( ! empty( $sidebar_id ) ) {
            $sidebar_settings_position = $sidebar_settings['position'];
        }

        $offset = $page * $load_by;

        $all_media_args = array(
            'post_type'      => 'media_gallery',
            'post_status'    => 'publish',
            'offset'         => $offset,
            'posts_per_page' => $load_by,
            'meta_key'       => '_thumbnail_id',
        );

        if ( $category != 'all' ) {
            $all_media_args['meta_query'] = array(
                array(
                    'key'     => 'media_type',
                    'value'   => $category,
                    'compare' => '='
                )
            );
        }

        $all_medias = new WP_Query( $all_media_args );

        $html = '';

        if ( $all_medias->have_posts() ) {
            if ( $load_by == 7 ) {
                $post_position = 0;
            } else {
                $post_position = $offset;
            }
            $style = 'style_' . rand( 1, 3 );
            while ( $all_medias->have_posts() ) {
                $all_medias->the_post();
                $post_position ++;
                if ( $post_position % $load_by == 0 ) {
                    $style = 'style_' . rand( 1, 3 );
                }
                ob_start();
                if($media_style == "style_2_3") stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
                else  stm_single_media_output_3x3( get_the_ID(), $post_position/$page-$load_by, 'style_2', $sidebar_settings_position, $disableMasonry);
                $html .= ob_get_clean();
            }


            $new_offset = $page + 1;
        }

        if ( $all_medias->found_posts < $offset + $load_by ) {
            $new_offset = 'none';
        }

        $json['offset'] = $new_offset;
        $json['html']   = $html;

        echo json_encode( $json );
        exit;
    }
}

add_action( 'wp_ajax_splash_load_media', 'splash_load_media' );
add_action( 'wp_ajax_nopriv_splash_load_media', 'splash_load_media' );


/*Soccer fn*/

if(!function_exists('stm_like')) {
    function stm_like()
    {
        $id = (esc_attr($_POST['id']) == '') ? 0 : esc_attr($_POST['id']);
        $likes = (get_post_meta($id, 'stm_like', true) == '') ? 0 : get_post_meta($id, 'stm_like', true);
        $likes++;
        update_post_meta($id, 'stm_like', $likes);
    }
}

add_action( 'wp_ajax_stm_like', 'stm_like' );
add_action( 'wp_ajax_nopriv_stm_like', 'stm_like' );


if(!function_exists('stm_league_table_by_id')) {
    function stm_league_table_by_id()
    {
        $id = $_GET['league_id'];
        $post_count = $_GET['count'];

        $defaults = array(
            'id' => $id,
            'number' => $post_count,
            'columns' => null,
            'highlight' => null,
            'show_full_table_link' => true,
            'show_title' => get_option( 'sportspress_table_show_title', 'yes' ) == 'yes' ? true : false,
            'show_team_logo' => get_option( 'sportspress_table_show_logos', 'yes' ) == 'yes' ? true : false,
            'link_posts' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
            'sortable' => get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false,
            'scrollable' => get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false,
            'paginated' => get_option( 'sportspress_table_paginated', 'yes' ) == 'yes' ? true : false,
            'rows' => $post_count,
        );

        extract( $defaults, EXTR_SKIP );

        if ( ! isset( $highlight ) ) $highlight = get_post_meta( $id, 'sp_highlight', true );

        $table = new SP_League_Table( $id );

        $output = '<div class="stm-single-league">';

        $output .= '<div class="sp-table-wrapper sp-scrollable-table-wrapper">';

        $output .= '<table class="sp-league-table sp-data-table sp-scrollable-table sp-sortable-table" data-sp-rows="5">' . '<thead>' . '<tr>';

        $data = $table->data();

        // The first row should be column labels
        $labels = $data[0];

        // Remove the first row to leave us with the actual data
        unset($data[0]);

        $columns = get_post_meta($id, 'sp_columns', true);

        if (null !== $columns && !is_array($columns))
            $columns = explode(',', $columns);

        $output .= '<th class="data-rank normal_font">' . esc_html__('N.', 'splash') . '</th>';

        foreach ($labels as $key => $label):
            if (!is_array($columns) || $key == 'name' || in_array($key, $columns))
                $output .= '<th class="data-' . $key . ' normal_font">' . $label . '</th>';
        endforeach;

        $output .= '</tr>' . '</thead>' . '<tbody>';

        $i = 0;
        $start = 0;

        if (intval($number) > 0):
            $limit = $number;

            // Trim table to center around highlighted team
            if ($highlight && sizeof($data) > $limit && array_key_exists($highlight, $data)):

                // Number of teams in the table
                $size = sizeof($data);

                // Position of highlighted team in the table
                $key = array_search($highlight, array_keys($data));

                // Get starting position
                $start = $key - ceil($limit / 2) + 1;
                if ($start < 0) $start = 0;

                // Trim table using starting position
                $trimmed = array_slice($data, $start, $limit, true);

                // Move starting position if we are too far down the table
                if (sizeof($trimmed) < $limit && sizeof($trimmed) < $size):
                    $offset = $limit - sizeof($trimmed);
                    $start -= $offset;
                    if ($start < 0) $start = 0;
                    $trimmed = array_slice($data, $start, $limit, true);
                endif;

                // Replace data
                $data = $trimmed;
            endif;
        endif;

        // Loop through the teams
        foreach ($data as $team_id => $row):

            if (isset($limit) && $i >= $limit) continue;

            $name = sp_array_value($row, 'name', null);
            if (!$name) continue;

            // Generate tags for highlighted team
            $tr_class = $td_class = '';
            if ($highlight == $team_id):
                $tr_class = ' highlighted';
                $td_class = ' sp-highlight';
            endif;

            $output .= '<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . $tr_class . ' sp-row-no-' . $i . '">';

            // Rank
            $output .= '<td class="data-rank' . $td_class . '">' . sp_array_value($row, 'pos') . '</td>';

            $name_class = '';


            if (has_post_thumbnail($team_id)):
                $team_link = get_permalink($team_id);
                $logo = get_the_post_thumbnail($team_id, 'sportspress-fit-icon');
                $name = '<a href="' . $team_link . '" class="team-logo"><div class="stm-league-table-team-logo">' . $logo . " </div>" . $name . '</a>';
                $name_class .= ' has-logo';
            endif;

            $output .= '<td class="data-name' . $name_class . $td_class . '">' . $name . '</td>';

            foreach ($labels as $key => $value):
                if (in_array($key, array('pos', 'name')))
                    continue;
                if (!is_array($columns) || in_array($key, $columns))
                    $output .= '<td class="data-' . $key . $td_class . '">' . sp_array_value($row, $key, '&mdash;') . '</td>';
            endforeach;

            $output .= '</tr>';

            $i++;
            $start++;

        endforeach;

        $output .= '</tbody>' . '</table>';

        $output .= '</div>';
        $output .= '</div>';

        ob_start();
        echo $output;

        $responce['table'] = ob_get_contents();
        $responce['link'] = get_the_permalink($id);

        ob_clean();

        echo json_encode($responce);
        exit;
    }
}

add_action( 'wp_ajax_stm_league_table_by_id', 'stm_league_table_by_id' );
add_action( 'wp_ajax_nopriv_stm_league_table_by_id', 'stm_league_table_by_id' );

if(!function_exists('stm_events_league_table_by_id')) {
    function stm_events_league_table_by_id() {
        $leagueId = $_GET['league_id'];
        $countPosts = $_GET['count'];
        $results_type = $_GET['results_type'];

        $latest_results_args = array(
            'post_status' => $results_type,
            'posts_per_page' => intval($countPosts),
            'post_type' => 'sp_event',
            'order' => 'DESC'
        );

        $latest_results_args['tax_query'][] = array(
            'taxonomy' => 'sp_league',
            'field'    => 'id',
            'terms'    => intval($leagueId),
        );

        $latest_results_query = new WP_Query($latest_results_args);

        $team_1_full_link = $team_2_full_link = '';

        $fixture_link = false;
        $venue_name = '';
        $prev_date = $prev_time = $prev_venue = '';

        ob_start();
        if($latest_results_query->have_posts()) {
            while ($latest_results_query->have_posts()):
                $latest_results_query->the_post();
                $teams = get_post_meta(get_the_ID(), 'sp_team', false);

                $point_system = splash_get_sportpress_points_system();

                if (count($teams) > 0):

                    $team_1_id = $teams[0];
                    $team_2_id = $teams[1];


                    $team_results = get_post_meta(get_the_ID(), 'sp_results', false);
                    $team_country_1 = get_post_meta($team_1_id, 'sp_custom_team_country', true);
                    $team_country_2 = get_post_meta($team_2_id, 'sp_custom_team_country', true);

                    $team_flag_1 = (class_exists('SportsPress') && !empty($team_country_1)) ? '<img src="' . plugin_dir_url(SP_PLUGIN_FILE) . 'assets/images/flags/' . strtolower($team_country_1) . '.png">' : '';
                    $team_flag_2 = (class_exists('SportsPress') && !empty($team_country_2)) ? '<img src="' . plugin_dir_url(SP_PLUGIN_FILE) . 'assets/images/flags/' . strtolower($team_country_2) . '.png">' : '';

                    /*Get teams meta*/
                    $team_1_title = get_the_title($team_1_id);
                    $team_2_title = get_the_title($team_2_id);

                    $date = new DateTime(get_the_time('Y/m/d H:i:s'));
                    if ($date) {
                        $date_show = get_post_time(get_option('date_format'), false, get_the_ID(), true);
                    }
                    ?>

                    <?php if ($prev_date != $date_show): ?>
                    <div class="stm-latest-results-meta heading-font">
                        <div class="date"><?php echo esc_attr($date_show); ?></div>
                    </div>
                <?php endif; ?>

                    <a href="<?php the_permalink(); ?>" class="stm-no-decoration" title="<?php the_title(); ?>">
                        <div class="stm-latest-results-info">
                            <div class="stm-latest-result-team heading-font">
                                <?php echo esc_html($team_1_title); ?>
                            </div>
                            <div class="stm-latest-results-points heading-font">
                            <div class="flag_wrap left">
                                <?php echo $team_flag_1; ?>
                            </div>
                            <?php if (!empty($team_results[0])): ?>
                                <?php if (!empty($team_results[0][$team_1_id]) and !empty($team_results[0][$team_2_id])): ?>
                                    <?php if (isset($team_results[0][$team_1_id][$point_system]) and isset($team_results[0][$team_2_id][$point_system])): ?>
                                        <?php if (!empty($team_results[0][$team_1_id])): ?>
                                            <?php
                                                if (isset($team_results[0][$team_1_id]['outcome']) and !empty($team_results[0][$team_1_id]['outcome'][0])) {
                                                    echo ($team_results[0][$team_1_id]['outcome'][0] == 'win') ? '<div class="stm-latest-result-win">' . esc_attr($team_results[0][$team_1_id][$point_system]) . '</div>' : esc_attr($team_results[0][$team_1_id][$point_system]);
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                        <?php endif; ?>
                                        /
                                        <?php if (!empty($team_results[0][$team_2_id])): ?>
                                            <?php
                                                if (isset($team_results[0][$team_2_id]['outcome']) and !empty($team_results[0][$team_2_id]['outcome'][0])) {
                                                    echo ($team_results[0][$team_2_id]['outcome'][0] == 'win') ? '<div class="stm-latest-result-win">' . esc_attr($team_results[0][$team_2_id][$point_system]) . '</div>' : esc_attr($team_results[0][$team_2_id][$point_system]);
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="flag_wrap right">
                                <?php echo $team_flag_2; ?>
                            </div>
                            </div>
                            <div class="stm-latest-result-team heading-font">
                                <?php echo esc_html($team_2_title); ?>
                            </div>
                        </div>
                    </a>
                <?php
                    $prev_date = $date_show;
                endif; /*Two team exists*/
            endwhile;
        }

        $responce['table'] = ob_get_contents();
        $responce['link'] = get_the_permalink($leagueId);

        ob_clean();

        echo json_encode($responce);
        exit;
    }
}

add_action( 'wp_ajax_stm_events_league_table_by_id', 'stm_events_league_table_by_id' );
add_action( 'wp_ajax_nopriv_stm_events_league_table_by_id', 'stm_events_league_table_by_id' );

if(!function_exists('stm_posts_most_styles')) {
    function stm_posts_most_styles () {
        $viewStyle = $_GET['viewStyle'];
        $categs = $_GET['categs'];
        $offset = $_GET['offset'];
        $limit = $_GET['limit'];
        $number_columns = $_GET['numColumns'];

        $tax = '';

        if(!empty($categs)) {
            $tax = array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categs)
                )
            );
        }

        $query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'offset' => $offset,
            'posts_per_page' => $limit,
            'tax_query' => $tax
        ));

        if($query->have_posts()) {
            $q = 0;
            ob_start();
            if($viewStyle != 'mixed_image') {
                while ($query->have_posts()) {
                    $query->the_post();
                    $padding = '';
                    if ($number_columns == 2) $padding = ($q % 2 == 1) ? 'pad-l-15' : 'pad-r-15';

                    if ($viewStyle == 'with_image') {
                        $class = 'row-content';
                        echo '<div class="' . $class . ' ' . $padding . '">';
                        get_template_part('partials/vc_templates_views/latest_news_most_styles_with-img-' . $class);
                        echo '</div>';
                        if ($number_columns == 2) {
                            echo ($q % 2 == 1) ? "<div class='clearfix'></div>" : '';
                        }
                    } else {
                        echo '<div class="no-img ' . $padding . '">';
                        get_template_part('partials/vc_templates_views/latest_news_most_styles_no-img');
                        echo '</div>';
                        if ($number_columns == 2) {
                            echo ($q % 2 == 1) ? "<div class='clearfix'></div>" : '';
                        }
                    }

                    $q++;
                }
            } else {
                $col = 'col-md-6 col-sm-6 col-xs-12';
                if ($number_columns == 2) $padding = 'col-md-12 col-sm-12 col-xs-12';
                $firstColumn = floor($query->post_count/2);
                $secondColumn = $query->post_count;
                $posts = $query->get_posts();
                ?>
                <div class="row">
                    <div class="<?php echo esc_attr($col); ?>">
                        <?php
                        for($i=0;$i<$firstColumn;$i++) {
                            $post = $posts[$i];
                            $post_id = $post->ID;
                            ?>
                            <div class="row-content ' . $padding . '">
                                <div class="latest-news-loop-with-img">
                                    <div class="wrap">
                                        <div class="img">
                                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'post-160-120')); ?>" />
                                        </div>
                                        <div class="meta">
                                            <div class="meta-top">
                                                <div class="categ">
                                                    <ul>
                                                        <?php
                                                        foreach( get_the_terms( $post_id, 'category' ) as $val) {
                                                            $catColor = get_term_meta($val->term_id, '_category_color', true);
                                                            echo '<li><a href="' . get_category_link($val->term_id) . '" class="normal_font" style="background-color: #' . $catColor . '">' . $val->name . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="meta-middle title heading-font">
                                                <a href="<?php echo get_the_permalink($post_id); ?>">
                                                    <?php echo get_the_title($post_id); ?>
                                                </a>
                                            </div>
                                            <div class="meta-bottom">
                                                <div class="date normal_font">
                                                    <?php echo get_the_date('d M, Y', $post_id); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="<?php echo esc_attr($col); ?>">
                        <?php
                        for($i=$firstColumn;$i<$secondColumn;$i++) {
                            $post = $posts[$i];
                            $post_id = $post->ID;
                            ?>
                            <div class="no-img">
                                <div class="latest-news-loop">
                                    <div class="meta">
                                        <div class="meta-top">
                                            <div class="categ">
                                                <ul>
                                                    <?php
                                                    foreach( get_the_terms( $post_id, 'category' ) as $val) {
                                                        $catColor = get_term_meta($val->term_id, '_category_color', true);
                                                        echo '<li><a href="' . get_category_link($val->term_id) . '" class="normal_font" style="background-color: #' . $catColor . '">' . $val->name . '</a></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="meta-middle">
                                            <a href="<?php echo get_the_permalink($post_id); ?>">
                                                <div class="title heading-font"><span class="date normal_font"><?php echo get_the_date('d M, Y', $post_id); ?></span> <?php echo get_the_title($post_id); ?></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }

            $responce['posts'] = ob_get_contents();
            $responce['offset'] = ($query->post_count >= $offset) ? $query->post_count : 'none';

            ob_clean();

            echo json_encode($responce);
            exit;
        }
    }
}

add_action( 'wp_ajax_stm_posts_most_styles', 'stm_posts_most_styles' );
add_action( 'wp_ajax_nopriv_stm_posts_most_styles', 'stm_posts_most_styles' );