<?php get_header();

//Get sidebar settings
$sidebar_settings = splash_get_sidebar_settings();
$sidebar_id = $sidebar_settings['id'];

$stm_sidebar_layout_mode = splash_sidebar_layout_mode($sidebar_settings['position'], $sidebar_id);

if(empty($stm_sidebar_layout_mode['sidebar_before'])) {
	$sidebar_settings['position'] = 'none';
}

$class = '';

if(is_layout("baseball")) $class = "news_style_baseball_" . $sidebar_settings["view_type"];
if(is_layout("magazine_one")) $class = "news_sidebar_" . $sidebar_settings["position"];


?>

	<div class="stm-default-page stm-default-page-<?php echo esc_attr($sidebar_settings['view_type']); ?> stm-default-page-<?php echo esc_attr($sidebar_settings['position']); ?>">
		<div class="container">
			<div class="row">
				<?php echo wp_kses_post($stm_sidebar_layout_mode['content_before']); ?>
                <?php if(!is_layout('magazine_one')): ?>
					<div class="stm-small-title-box">
						<?php if(!is_layout('soccer_two')) get_template_part('partials/global/title-box'); ?>
					</div>
                <?php endif; ?>
					<?php if(have_posts()): ?>
						<div class="row row-3 row-sm-2 <?php echo $class; ?>">

							<?php
                            $template = 'partials/loop/content-'.$sidebar_settings["view_type"];
                            $layoutName = getThemeSettings();
                            switch ($layoutName['layoutName']) {
                                case 'baseball':
                                    $template = 'partials/loop/content-' . $sidebar_settings["view_type"] . '-baseball';
                                    break;
                                case 'magazine_one':
                                    $template = 'partials/loop/content-' . $sidebar_settings["view_type"] . '-magazine-one';
                                    break;
                            }

                            while(have_posts()): the_post();
                                get_template_part($template);
                            endwhile; ?>

						</div>
						<?php splash_pagination(); ?>
					<?php else: ?>

						<h5 class="text-transform nothing found"><?php esc_html_e('No Results', 'splash'); ?></h5>

					<?php endif; ?>

				<?php echo wp_kses_post($stm_sidebar_layout_mode['content_after']); ?>

				<!--Sidebar-->
				<?php splash_display_sidebar(
					$sidebar_id,
					$stm_sidebar_layout_mode['sidebar_before'],
					$stm_sidebar_layout_mode['sidebar_after'],
					$sidebar_settings['blog_sidebar']
				); ?>

			</div>
		</div>
	</div>


<?php get_footer(); ?>