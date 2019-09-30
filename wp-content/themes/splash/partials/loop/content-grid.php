<?php
$layoutName = getThemeSettings();
$col = (is_layout("sccr")) ? "col-md-3 col-sm-4 col-xs-6" : "col-md-4 col-sm-4";
?>
<?php $cat = wp_get_post_terms(get_the_ID(), "category"); ?>
<div class="<?php echo $col; ?>">
	<div <?php post_class('stm-single-post-loop'); ?>>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">

			<?php if(has_post_thumbnail()): ?>
				<?php if(is_layout('soccer_two') || !is_search()): ?>
				<div class="image <?php if(get_post_format(get_the_ID())) echo get_post_format(get_the_ID()); ?>">
					<div class="stm-plus"></div>
					<?php if(is_layout("bb")){
                        (get_the_post_thumbnail_url(get_the_ID(),'stm-570-350', array('class' => 'img-responsive'))) ? the_post_thumbnail('stm-570-350', array('class' => 'img-responsive')) : the_post_thumbnail('full', array('class' => 'img-responsive'));
                    } elseif(is_layout("sccr")) {
                        (get_the_post_thumbnail_url(get_the_ID(),'blog_list', array('class' => 'img-responsive'))) ? the_post_thumbnail('blog_list', array('class' => 'img-responsive')) : the_post_thumbnail('full', array('class' => 'img-responsive'));
					} elseif(is_layout("soccer_two")) {
						(get_the_post_thumbnail_url(get_the_ID(),'post-370-210', array('class' => 'img-responsive'))) ? the_post_thumbnail('post-370-210', array('class' => 'img-responsive')) : the_post_thumbnail('full', array('class' => 'img-responsive'));
					}
					else {
                        (get_the_post_thumbnail_url(get_the_ID(),'stm-255-183', array('class' => 'img-responsive'))) ? the_post_thumbnail('stm-255-183', array('class' => 'img-responsive')) : the_post_thumbnail('full', array('class' => 'img-responsive'));
                    } ?>
					<?php if(is_sticky(get_the_id())): ?>
						<div class="stm-sticky-post heading-font"><?php esc_html_e('Sticky Post','splash'); ?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			<?php else: ?>
				<?php if(is_sticky(get_the_id())): ?>
					<div class="stm-sticky-post stm-sticky-no-image heading-font"><?php esc_html_e('Sticky Post','splash'); ?></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if(!is_layout("sccr") && !is_layout('soccer_two')): ?>
			<div class="date <?php echo (!is_layout("af")) ? "heading-font" : "normal_font"; ?>">
				<?php echo esc_attr(get_the_date()); ?>
			</div>
			<?php endif; ?>

			<?php if(!is_layout("sccr")): ?>
			<div class="post-info-sccr-two">
				<div class="title heading-font">
					<?php the_title(); ?>
				</div>
				<?php
				if(count($cat) > 0) :
					$catList = "<span class='cats'>";
					$catList = $catList . $cat[0]->name;
					$catList = $catList . "</span>";
					?>

					<div class="stm-cat-list-wrapp">
						<?php echo $catList; ?>
					</div>
				<?php endif; ?>
				<div class="stm-post-time">
					<?php echo esc_attr(get_the_date()); ?>
				</div>
			</div>
			<?php endif; ?>

		</a>

		<?php if(!is_af() && !is_layout('soccer_two')): ?>
		<div class="content">
			<?php if(is_layout("sccr")): ?>
				<div class="title heading-font">
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</div>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		</div>
		<?php endif; ?>

		<div class="post-meta <?php echo (is_layout("bb")) ? "heading-font" : "normal_font"; ?>">
			<!--category-->
			<?php if($layoutName["layoutName"] == "af"):?>

				<?php
				if(count($cat) > 0) :
					$catList = "<ul>";
					//foreach ($cat as $k => $val) {
						$catList = $catList . "<li><a href='" . get_term_link($cat[0]->term_id) . "'>" . $cat[0]->name;
					//	if(($k + 1) < count($cat)) $catList = $catList . ", ";
						$catList = $catList . "</a></li>";
					//}
					$catList = $catList . "</ul>";
					?>

					<div class="stm-cat-list-wrapp">
						<i class="fa fa-folder-o" aria-hidden="true"></i>
						<?php echo $catList; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php if(is_layout("sccr")): ?>
				<div class="stm-post-time">
					<?php echo esc_attr(get_the_date()); ?>
				</div>
			<?php endif; ?>
			<!--comments-->
			<?php if(!is_layout('soccer_two')): ?>
			<?php $comments_num = get_comments_number(get_the_id()); ?>
			<?php if($comments_num): ?>
				<div class="comments-number">
					<a href="<?php the_permalink() ?>#comments">
					<?php echo (!is_layout("bb")) ? '<i class="fa fa-comment-o" aria-hidden="true"></i>' : '<i class="fa fa-commenting"></i>' ;?>
						<span><?php echo esc_attr($comments_num); ?> <?php if($layoutName["layoutName"] == "af") echo esc_html_e('comments', 'splash'); ?></span>
					</a>
				</div>
			<?php else: ?>
				<div class="comments-number">
					<a href="<?php the_permalink() ?>#comments">
						<?php echo (!is_layout("bb")) ? '<i class="fa fa-comment-o" aria-hidden="true"></i>' : '<i class="fa fa-commenting"></i>' ;?>
						<span>0 <?php if($layoutName["layoutName"] == "af") echo esc_html_e('comments', 'splash'); ?></span>
					</a>
				</div>
			<?php endif; ?>
			<?php endif; ?>
			<!--tags-->
			<?php if($layoutName["layoutName"] != "af" && !is_layout('soccer_two')):?>
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
			<?php endif; ?>
		</div>

	</div>
</div>