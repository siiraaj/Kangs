<?php
/*
  ["exclude_categories"]        => string(6) "enable"
  ["checked_exclude_categories"]=> string(1) "1"
  ["total_posts"]               => string(2) "10"
  ["link_target"]               => string(11) "same_window"
  ["show_post_date"]            => string(6) "enable"
  ["date_format"]               => string(5) "Y/m/d"
  ["show_ticker_title"]         => string(6) "enable"
  ["ticker_title_color"]        => string(7) "#dd3333"
  [ticker_first_word_color] =>
  ["ticker_title_position"]     => string(5) "right"
  ["ticker_title_text"]         => string(12) "TIcker title"
  ["ticker_bg_color"]           => string(7) "#6b6b6b"
  ["ticker_direction"]          => string(2) "up"
  ["ticker_auto_play_speed"]    => string(4) "3000"
  [ticker_icon] => icon-soccer_ico_ticker_post
 * */

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$postsPerPage = (!empty($atts['total_posts'])) ? $atts['total_posts'] : 10;
$tickerBG = (!empty($atts['ticker_bg_color'])) ? $atts['ticker_bg_color'] : '#cccccc';
$tickerTitle = (!empty($atts["ticker_title_text"])) ? $atts['ticker_title_text'] : "";
$tickerTitleColor = (!empty($atts['ticker_title_color'])) ? $atts['ticker_title_color'] : '#000000';
$ticker_first_word_color = (!empty($atts['ticker_first_word_color'])) ? $atts['ticker_first_word_color'] : '#000000';
$tickerTitlePosition = ($atts['ticker_title_position'] == "left") ? 'order: 1"' : 'order: 2;';
$tickerTitlePositionClass = $atts['ticker_title_position'];
$linkTarget = ($atts['link_target'] == 'link_target') ? '' : 'target="_blank"';
$tickerDirection = $atts['ticker_direction'];
$tickerDirectionClass = ($atts['ticker_direction'] == "up") ? "stmTickerPostsListTop" : "stmTickerPostsListBottom";
$tickerAPS = $atts['ticker_auto_play_speed'];
$tickerAS = $atts['ticker_animate_speed'];
$tickerIcon = (!empty($atts["ticker_icon"])) ? $atts["ticker_icon"] : "";


$args = array(
	'post_type'     => 'post',
	'post_status'   => 'publish',
	'posts_per_page'=> $postsPerPage,
	'order'         => 'ASC',
	'orderby'       => 'ID'
);

if(!empty($atts['exclude_categories']) && $atts['exclude_categories'] == 'enable') {
	$args['category__not_in'] = explode(',', $atts['checked_exclude_categories']);
}

$query = new WP_Query($args);
?>

<div class="stmTickerWrapper" style="background: <?php echo $tickerBG; ?>;">
	<div class="container">
		<div class="stmTickerContent">
			<div class="stmTickerTitle heading-font <?php echo $tickerTitlePositionClass; ?>" style="<?php echo $tickerTitlePosition; ?> color: <?php echo $tickerTitleColor; ?>;">
				<?php
				if($ticker_first_word_color != ""){
					$word = explode(" ", $tickerTitle);
					$tickerTitle = str_replace($word[0], '<span style="color: ' . $ticker_first_word_color . ';">' . $word[0] . '</span>', $tickerTitle);
				}
				echo $tickerTitle;
				?>
			</div>
			<div class="stmTickerPostsWrapper">
				<ul class="stmTickerPostsList <?php echo $tickerDirectionClass; ?>" data-direction="<?php echo $tickerDirection; ?>" data-auto_play_speed="<?php echo $tickerAPS; ?>" data-animate_speed="<?php echo $tickerAS; ?>" data-count-posts="<?php echo $query->post_count; ?>">
					<?php
					if($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
					?>
							<li class="tickerItem" data-id="<?php echo get_the_ID(); ?>">
								<div class="stm-ticker-post">
									<?php if($tickerIcon != "") : ?>
										<i class="<?php echo $tickerIcon; ?>" ></i>
									<?php endif; ?>
									<a href="<?php echo get_the_permalink(); ?>">
										<span class="normal_font"><?php echo get_the_title(); ?></span>
									</a>
									<?php if($atts["show_post_date"]) : ?>
										<span class="ticker-post-divider normal_font">/</span><span><?php echo get_the_date();?></span>
									<?php endif;?>
								</div>
							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php wp_reset_query(); ?>