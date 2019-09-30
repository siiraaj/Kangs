<?php
$team = $player_list = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
splash_enqueue_modul_scripts_styles('stm_post_slider');

$tax = '';

if(!empty($post_categories)) {
	$tax = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => explode(',', $post_categories)
		)
	);
}

$query = new WP_Query(array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'ignore_sticky_posts' => 1,
	'posts_per_page' => $number_posts,
	'tax_query' => $tax
));
?>

<?php
	if($query->have_posts()):
		$id = 0;
		$dots = array();
	?>
	<div class="stm-post__slider container">
		<div class="stm-post__slides">
			<?php
			while($query->have_posts()):
				$id++;
				$query->the_post(); ?>
				<div class="stm-slide <?php echo $id == 1 ? 'active' : ''; ?>" id="slide-<?php echo $id; ?>">
					<div class="stm-post__slider__image" style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_id(), 'full')); ?>)">
					</div>
					<div class="stm-post__slider__data container">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<span class="stm-slide__category">
									<?php
									$category = get_the_category(get_the_id());
									echo $category[0]->name;
									?>
								</span>
								<div class="stm-slide__title heading-font">
									<?php the_title(); ?>
								</div>
								<div class="stm-slide__excerpt">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="stm-slide__link heading-font">
									<?php echo esc_html_e('Read more', 'splash'); ?>
									<i class="icon-mg-icon-arrow-italic"></i>
								</a>
							</div>
						</div>

					</div>
				</div>
				<?php $dots[] = get_the_title(); ?>
			<?php endwhile; ?>
		</div>
		<ul class="stm-post__slider__nav">
			<?php
			$slide_nav = 0;
			foreach ($dots as $dot):
				$slide_nav++;
				?>
				<li class="<?php echo $slide_nav == 1 ? 'active' : ''; ?>">
					<a href="#slide-<?php echo $slide_nav; ?>" class="heading-font"><?php echo $dot; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

<?php endif; ?>