<?php if(!is_layout('magazine_one') && !is_layout('soccer_two')) get_template_part('partials/global/title-box'); ?>

<div class="clearfix">
	<?php the_content(); ?>
</div>

<?php
if(!is_layout("baseball")) {
	get_template_part('partials/global/sportspress/player-media');
	get_template_part('partials/global/sportspress/player-related');
}

if(is_layout("sccr")) {
?>
	<div class="stm-share-this-wrapp list_fade" style="text-align: <?php echo esc_attr($atts['position']); ?>;">
		<span>SHARE</span>
		<span class="stm-share-btn-wrapp">
		<?php if(function_exists('A2A_SHARE_SAVE_pre_get_posts')) echo A2A_SHARE_SAVE_add_to_content(""); ?>
	</span>
	</div>
	<?php
}
?>
