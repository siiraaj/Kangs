<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
splash_enqueue_modul_scripts_styles('stm_next_match_carousel');
$count = $count > 0 ? $count - 1 : $count;
$next_match_args = array(
	'post_status'    => 'future',
	'posts_per_page' => intval($count),
	'post_type'      => 'sp_event',
	'order'          => 'ASC'
);

if(!empty($pick_team)) {
	$next_match_args['meta_query'][] = array(
		'key' => 'sp_team',
		'value' => intval($pick_team),
		'compare' => 'IN'
	);
}
$next_match_query = new WP_Query($next_match_args);

$past_match_args = array(
	'post_status'    => 'closed',
	'posts_per_page' => 1,
	'post_type'      => 'sp_event',
	'order'          => 'ASC'
);

if(!empty($pick_team)) {
	$past_match_args['meta_query'][] = array(
		'key' => 'sp_team',
		'value' => intval($pick_team),
		'compare' => 'IN'
	);
}
$past_match_query = new WP_Query($past_match_args);

?>
<div class="stm-next-match-carousel-wrap">
	<h2 class="stm-carousel-title">
		<?php echo esc_html($title); ?>
	</h2>
	<div class="stm-next-match-carousel">

		<?php if($past_match_query->have_posts()): ?>
			<?php while($past_match_query->have_posts()):
				$past_match_query->the_post(); ?>
				<div class="stm-next-match-carousel__item">
					<div class="event-results">
						<?php
						$id = get_the_ID();
						$event = new SP_Event( $id );
						$data = $event->results();
						unset( $data[0] );
						$teams = get_post_meta(get_the_id(), 'sp_team', false);
						$team_results = get_post_meta(get_the_ID(), 'sp_results', false);
						$team_1_id = $teams[0];
						$team_2_id = $teams[1];
						$team_1_url = get_permalink($team_1_id);
						$team_2_url = get_permalink($team_2_id);
						$team_1_title = get_the_title($team_1_id);
						$team_2_title = get_the_title($team_2_id);
						$team_1_goals = $data[$team_1_id]['goals'];
						$team_2_goals = $data[$team_2_id]['goals'];
						$team_1_img_url = splash_get_thumbnail_url($team_1_id, '', 'thumbnail');
						$team_2_img_url = splash_get_thumbnail_url($team_2_id, '',  'thumbnail');
						$sp_league = wp_get_post_terms($id, 'sp_league');
						$league = $sp_league[0]->name;
						$venues = get_the_terms($id, 'sp_venue');
						$venue = $venues[0]->name;
						?>
						<a href="<?php echo esc_url($team_1_url); ?>">
							<img src="<?php echo esc_url($team_1_img_url); ?>" alt="<?php echo esc_html_e($team_1_title, 'splash'); ?>">
						</a>
						<?php if(!empty($team_1_goals) && !empty($team_2_goals)): ?>
							<span class="post-score heading-font">
					<?php echo esc_html($team_1_goals . ' : ' . $team_2_goals); ?>
				</span>
						<?php else: ?>
							<span class="post-score">
					<?php echo esc_html_e('vs', 'splash'); ?>
				</span>
						<?php endif; ?>
						<a href="<?php echo esc_url($team_1_url); ?>">
							<img src="<?php echo esc_url($team_2_img_url); ?>" alt="<?php echo esc_html_e($team_2_title, 'splash'); ?>">
						</a>
					</div>
					<div class="event-data">
						<a href="<?php the_permalink(); ?>">
							<div class="teams-titles">
								<?php the_title(); ?>
							</div>
						</a>
						<div class="event-league">
							<?php echo esc_html($league); ?>
						</div>
					</div>
					<div class="event-date">
						<?php
						the_date();
						echo esc_html(' ' . $venue)
						?>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<?php if($next_match_query->have_posts()): ?>
			<?php while($next_match_query->have_posts()):
				$next_match_query->the_post(); ?>
				<div class="stm-next-match-carousel__item">
					<div class="event-results">
						<?php
						$id = get_the_ID();
						$event = new SP_Event( $id );
						$data = $event->results();
						unset( $data[0] );
						$teams = get_post_meta(get_the_id(), 'sp_team', false);
						$team_results = get_post_meta(get_the_ID(), 'sp_results', false);
						$team_1_id = $teams[0];
						$team_2_id = $teams[1];
						$team_1_url = get_permalink($team_1_id);
						$team_2_url = get_permalink($team_2_id);
						$team_1_title = get_the_title($team_1_id);
						$team_2_title = get_the_title($team_2_id);
						$team_1_img_url = splash_get_thumbnail_url($team_1_id, '', 'thumbnail');
						$team_2_img_url = splash_get_thumbnail_url($team_2_id, '',  'thumbnail');
						$sp_league = wp_get_post_terms($id, 'sp_league');
						$league = $sp_league[0]->name;
						$venues = get_the_terms($id, 'sp_venue');
						$venue = $venues[0]->name;
						?>
						<a href="<?php echo esc_url($team_1_url); ?>">
							<img src="<?php echo esc_url($team_1_img_url); ?>" alt="<?php echo esc_html_e($team_1_title, 'splash'); ?>">
						</a>
						<span class="post-score heading-font">
						<?php echo esc_html_e('vs', 'splash'); ?>
					</span>
						<a href="<?php echo esc_url($team_1_url); ?>">
							<img src="<?php echo esc_url($team_2_img_url); ?>" alt="<?php echo esc_html_e($team_2_title, 'splash'); ?>">
						</a>
					</div>
					<div class="event-data">
						<a href="<?php the_permalink(); ?>">
							<div class="teams-titles">
								<?php the_title(); ?>
							</div>
						</a>
						<div class="event-league">
							<?php echo esc_html($league); ?>
						</div>
					</div>
					<div class="event-date">
						<?php
						the_date();
						echo esc_html(' ' . $venue)
						?>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</div>
