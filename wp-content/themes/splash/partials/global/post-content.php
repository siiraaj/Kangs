<?php
	$sidebar_id = get_theme_mod('sidebar_blog', 'primary_sidebar');
	$sidebar_position = get_theme_mod('sidebar_position', 'left');

	if( !empty($sidebar_id) ) {
		$blog_sidebar = get_post( $sidebar_id );
	} else {
		$blog_sidebar = '';
	}

	if($sidebar_id == 'no_sidebar') {
		$sidebar_id = false;
	}

	$stm_sidebar_layout_mode = splash_sidebar_layout_mode($sidebar_position, $sidebar_id);
	$format = get_post_format();

$layoutName = getThemeSettings();

?>

<div class="row stm-format-<?php echo esc_attr($format); ?> <?php if(is_af()) echo "stm-post-af-wrapp"; ?>">
	<?php echo wp_kses_post($stm_sidebar_layout_mode['content_before']); ?>
        <div class="stm-small-title-box">
            <?php if(!is_layout('soccer_two')) get_template_part('partials/global/title-box'); ?>
        </div>

		<!--Post thumbnail-->
		<?php if ( has_post_thumbnail() ): ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'stm-1170-650', array( 'class' => 'img-responsive' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="stm-single-post-meta clearfix <?php echo (is_layout("bb")) ? "heading-font" : "normal_font"; ?>">

			<div class="stm-meta-left-part">
				<?php if(!is_layout('sccr')) : ?>
					<div class="stm-date">
						<i class="fa fa-calendar-o"></i>
						<?php echo get_the_date(); ?>
					</div>
					<div class="stm-author">
						<i class="fa <?php echo (!is_af()) ? "fa-user" : "fa-pencil-square-o"; ?>"></i>
						<?php the_author(); ?>
					</div>
				<?php else: ?>
					<div class="stm-date">
						<?php echo esc_html("Posted by", 'spash') . " " . get_the_author() . " " . esc_html("on", 'splash') . " " . get_the_date(); ?>
					</div>
				<?php endif;?>
                <?php echo getPostViewsCountHtml(get_the_ID()); ?>
			</div>

			<div class="stm-comments-num">
				<a href="<?php comments_link(); ?>" class="stm-post-comments">
					<?php echo ($layoutName["layoutName"] == "af") ? '<i class="fa fa-comment-o" aria-hidden="true"></i>' : '<i class="fa fa-commenting"></i>' ;?>
					<?php comments_number("", "", "% comments"); ?>
				</a>
			</div>

			<!--category-->
			<?php $lName = getThemeSettings();?>
			<?php if($lName["layoutName"] == "af" || is_layout("baseball")):?>
				<?php $cat = wp_get_post_terms(get_the_ID(), "category"); ?>
				<?php
				if(count($cat) > 0) :
					$catList = "<ul>";
					foreach ($cat as $k => $val) {
						$catList = $catList . "<li><a href='" . get_term_link($cat[$k]->term_id) . "'>" . $cat[$k]->name;
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
			<?php endif; ?>

		</div>


		<div class="post-content">
			<?php the_content(); ?>
			<div class="clearfix"></div>
		</div>

		<?php splash_pages_pagination(); ?>


		<div class="stm-post-meta-bottom <?php echo (is_layout("bb")) ? "heading-font" : "normal_font"; ?> clearfix">
			<div class="stm_post_tags">
				<?php if(!is_af()) : the_tags( '<i class="fa fa-tag"></i>',',' ); else : the_tags( '<i class="fa fa-tags"></i>',',' ); endif; ?>
			</div>

			<?php if(is_layout("bb")): ?>
			<div class="stm_post_share">
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="//w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false,onhover: false});</script>
				<div class="stm-share"><i class="fa fa-share-alt"></i><?php esc_html_e('Share', 'splash'); ?></div>
			</div>
			<?php else : ?>
				<div class="stm-share-this-wrapp <?php if(is_layout("sccr")) echo "dropdown"; ?>">
					<span><?php echo esc_html_e("share", 'splash'); ?></span>
					<span class="stm-share-btn-wrapp">
						<?php if(function_exists('A2A_SHARE_SAVE_pre_get_posts')) echo A2A_SHARE_SAVE_add_to_content(""); ?>
					</span>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( get_the_author_meta('description') ) : ?>
			<?php if($layoutName["layoutName"] == "bb"): ?>
			<div class="stm_author_box clearfix">
				<div class="author_avatar">
					<?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?>
				</div>
				<div class="author_info">
					<div class="author_name">
						<h6 class="text-transform"><?php esc_html_e( 'About the Author:', 'splash' ); ?>
							<span class="stm-red"><?php the_author_meta('nickname'); ?></span>
						</h6>
					</div>
					<div class="author_content">
						<?php echo get_the_author_meta( 'description' ); ?>
					</div>
				</div>
			</div>
			<?php elseif($layoutName["layoutName"] == "af"): ?>
				<div class="stm_author_box clearfix">
					<div class="stm-author-title-bg">
						<div class="stm-author-title heading-font">
							<?php esc_html_e( 'About Author', 'splash' ); ?>
						</div>
					</div>
					<div class="author_avatar">
						<?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?>
					</div>
					<div class="author_info">
						<div class="author_name">
							<h6 class="text-transform">
								<span class="stm-red"><?php the_author_meta('nickname'); ?></span>
							</h6>
						</div>
						<div class="author_content">
							<?php echo get_the_author_meta( 'description' ); ?>
						</div>
					</div>
				</div>
			<?php elseif($layoutName["layoutName"] == "sccr"): ?>
				<div class="stm_author_box clearfix">
					<div class="author_name">
						<h6 class="text-transform">
							<?php esc_html_e( 'About Author', 'splash' ); ?>: <?php the_author_meta('nickname'); ?>
						</h6>
					</div>
					<div class="author_info-wrap">
						<div class="author_avatar">
							<?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?>
						</div>
						<div class="author_info">
							<div class="author_content">
								<?php echo get_the_author_meta( 'description' ); ?>
							</div>
						</div>
					</div>
				</div>
            <?php elseif($layoutName["layoutName"] == "baseball"): ?>
                <div class="stm_author_box clearfix">
                    <div class="stm-author-title-bg">
                        <div class="stm-author-title heading-font">
                            <?php esc_html_e( 'About Author', 'splash' ); ?>
                        </div>
                    </div>
                    <div class="author_avatar">
                        <?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?>
                    </div>
                    <div class="author_info">
                        <div class="author_name">
                            <h5 class="text-transform">
                                <span class="stm-red"><?php the_author_meta('nickname'); ?></span>
                            </h5>
                        </div>
                        <div class="author_content">
                            <?php echo get_the_author_meta( 'description' ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
		<?php endif; ?>

		<!--Comments-->
		<?php if ( comments_open() || get_comments_number() ) { ?>
			<div class="stm_post_comments">
				<?php comments_template(); ?>
			</div>
		<?php } ?>

	<?php echo wp_kses_post($stm_sidebar_layout_mode['content_after']); ?>


	<!--Sidebar-->
	<?php splash_display_sidebar(
		$sidebar_id,
		$stm_sidebar_layout_mode['sidebar_before'],
		$stm_sidebar_layout_mode['sidebar_after'],
		$blog_sidebar
	); ?>
</div>