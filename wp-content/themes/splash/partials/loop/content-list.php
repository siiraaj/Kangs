<?php $layoutName = getThemeSettings(); ?>
<div class="col-md-12">
	<div <?php post_class('stm-single-post-loop stm-single-post-loop-list'); ?>>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">

			<?php if(has_post_thumbnail()): ?>
				<div class="image <?php if(get_post_format(get_the_ID())) echo get_post_format(get_the_ID()); ?>">
					<div class="stm-plus"></div>
					<?php
					$imgSize = "stm-1170-650";
					if(is_layout("af")) $imgSize = "stm-350-250";
					elseif(is_layout("sccr")) $imgSize = "blog_list";

					the_post_thumbnail($imgSize, array('class' => 'img-responsive')); ?>
					<?php if(is_sticky(get_the_id())): ?>
						<div class="stm-sticky-post heading-font"><?php esc_html_e('Sticky Post','splash'); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</a>

		<div class="stm-post-content-inner">

			<?php if(is_layout("af") || is_layout("sccr")): ?>
				<div class="date">
					<?php echo esc_attr(get_the_date()); ?>
				</div>
			<?php endif;?>

			<a href="<?php the_permalink() ?>">
				<div class="title heading-font">
					<?php the_title(); ?>
				</div>
			</a>

			<div class="clearfix">
				<?php if(is_layout("bb")): ?>
					<div class="date <?php echo (!is_layout("af")) ? "heading-font" : "normal_font"; ?>">
						<?php echo esc_attr(get_the_date()); ?>
					</div>

					<div class="post-meta heading-font">
						<?php $comments_num = get_comments_number(get_the_id()); ?>
						<?php if($comments_num): ?>
							<div class="comments-number">
								<a href="<?php the_permalink() ?>#comments">
									<i class="fa fa-commenting"></i>
									<span><?php echo esc_attr($comments_num); ?></span>
								</a>
							</div>
						<?php else: ?>
							<div class="comments-number">
								<a href="<?php the_permalink() ?>#comments">
									<i class="fa fa-commenting"></i>
									<span>0</span>
								</a>
							</div>
						<?php endif; ?>

						<?php $posttags = get_the_tags();
						if ($posttags): ?>
							<div class="post_list_item_tags">
								<?php $count = 0; foreach($posttags as $tag): $count++; ?>
									<?php if($count == 1): ?>
										<a href="<?php echo get_tag_link($tag->term_id); ?>">
											<i class="fa fa-tag"></i>
											<?php echo($tag->name); ?>
										</a>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif;?>
			</div>

			<div class="content">
				<?php the_excerpt(); ?>
			</div>

			<?php if(is_layout("af") || is_layout("sccr")): ?>
				<div class="post-meta normal_font">
					<?php $cat = wp_get_post_terms(get_the_ID(), "category"); ?>
					<?php
					if(count($cat) > 0) :
						$catList = "<ul>";
						foreach ($cat as $k => $val) {
							$catList = $catList . "<li><a href='" . get_term_link($val->term_id) . "'>" . $val->name;
							if(($k + 1) < count($cat)) $catList = $catList . ", ";
							$catList = $catList . "</a></li>";
						}
						$catList = $catList . "</ul>";
					?>
						
					<div class="stm-cat-list-wrapp">
						<i class="fa fa-folder-o" aria-hidden="true"></i>
						<?php echo $catList; ?>
					</div>
					<?php endif; ?>

					<?php $comments_num = get_comments_number(get_the_id()); ?>
					<?php if($comments_num): ?>
						<div class="comments-number">
							<a href="<?php the_permalink() ?>#comments">
								<i class="fa fa-comment-o" aria-hidden="true"></i>
								<span><?php echo esc_attr($comments_num); ?> <?php if($layoutName["layoutName"] == "af") echo esc_html_e('comments', 'splash'); ?></span>
							</a>
						</div>
					<?php else: ?>
						<div class="comments-number">
							<a href="<?php the_permalink() ?>#comments">
								<i class="fa fa-comment-o" aria-hidden="true"></i>
								<span>0 <?php if($layoutName["layoutName"] == "af") echo esc_html_e('comments', 'splash');?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>