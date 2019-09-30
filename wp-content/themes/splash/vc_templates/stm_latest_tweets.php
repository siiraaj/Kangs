<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$base_color = get_theme_mod("site_style_base_color", "");

if(!empty($base_color)) :
?>

<style type="text/css">
    .stm-tweets-wrapp .stm-latest-tweets .latest-tweets ul li:before, .stm-tweets-wrapp .stm-latest-tweets .latest-tweets ul li .tweet-details a{
        color: <?php echo $base_color; ?>;
    }
</style>

<?php endif; ?>

<div class="container">
	<div class="stm-tweets-wrapp">
		<div class="clearfix">
			<<?php echo esc_html(getHTag()); ?>><?php echo esc_html($atts["latest_tweets_title"]); ?></<?php echo esc_html(getHTag()); ?>>
		</div>
		<div class="stm-latest-tweets normal_font">
			<?php if(function_exists('latest_tweets_render_html')) echo latest_tweets_render_html(esc_html($atts['latest_tweets_name']), 3); ?>
		</div>
	</div>
</div>