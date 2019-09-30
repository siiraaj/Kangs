<?php
/**
 * Team Staff
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version   2.5.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();

$team = new SP_Team( $id );
$members = $team->staff();
$link_staff = get_option( 'sportspress_team_link_staff', 'no' ) === 'yes' ? true : false;

if(!empty($members)): ?>
	<h4 class="sp-table-caption">
		<?php esc_html_e('Coaching Staff', 'splash'); ?>
	</h4>
	<div class="stm-team-staff-list">
		<div class="stm-team-staff-list-inner clearfix">
			<?php foreach ( $members as $staff ):

				//var_dump($staff);

				$id = $staff->ID;
				$name = $staff->post_title;
				$countries = SP()->countries->countries;
				
				$staff = new SP_Staff( $id );
				$role = $staff->role();
				$nationalities = $staff->nationalities();
				$nationality = '';
				if( !empty($nationalities) and !empty($nationalities[0])) {
					$nationality = $nationalities[0];
					if ( 2 == strlen( $nationality ) ):
						$legacy = SP()->countries->legacy;
						$nationality = strtolower( $nationality );
						$nationality = sp_array_value( $legacy, $nationality, null );
					endif;
					$country_name = sp_array_value( $countries, $nationality, null );
				}

				$role_name = '';

				if($role) {
					$role_name = $role->name;
				}

				if(!is_af()):
				?>
					<div class="stm-single-staff">
						<div class="inner">
							<div class="stm-red heading-font"><?php echo esc_attr($role_name); ?></div>
							<h4 class="sp-staff-name heading-font"><?php echo esc_attr($name); ?></h4>
							<?php if(!empty($country_name)): ?>
								<div class="nationality">
									(<?php esc_html_e('Nationality', 'splash'); ?>: <?php echo esc_attr($country_name); ?>)
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php
				else:

					$pastTeamsArray = $staff->past_teams();
					$pastTeamsList = array();
					foreach($pastTeamsArray as $k => $val){
						$pastTeamsList[$k] = sp_get_team_name($val);
					}
				?>
					<div class="stm-single-staff">
						<div class="inner">
							<h4 class="sp-staff-name heading-font"><?php echo esc_attr($name); ?></h4>
							<div class="stm-staff-info-wrapp">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-4">
										<div class="stm-staff-img-wrapp">
											<?php echo get_the_post_thumbnail( $id, 'full' ) ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-8">
										<div class="stm-staff-info">
											<div class="stm-staff-role heading-font"><?php echo esc_attr($role_name); ?></div>
											<table>
												<?php if(get_post_meta($id, 'staff_age') != null): ?>
												<tr>
													<td><?php esc_html_e('Age:', 'splash'); ?></td>
													<td><?php $age = get_post_meta($id, 'staff_age'); echo esc_html($age[0]); ?></td>
												</tr>
												<?php endif; ?>
												<?php if(get_post_meta($id, 'staff_college') != null): ?>
												<tr>
													<td><?php esc_html_e('College:', 'splash'); ?></td>
													<td><?php $collage = get_post_meta($id, 'staff_college'); echo esc_html($collage[0]); ?></td>
												</tr>
												<?php endif;?>
												<?php if(get_post_meta($id, 'staff_experience') != null): ?>
												<tr>
													<td><?php esc_html_e('Experience:', 'splash'); ?></td>
													<td><?php $experience = get_post_meta($id, 'staff_experience'); echo esc_html($experience[0]); ?></td>
												</tr>
												<?php endif; ?>
												<tr>
													<td><?php esc_html_e('Nationality:', 'splash'); ?></td>
													<td>
														<?php if(!empty($country_name)): ?>
															<div class="nationality">
																<?php echo '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '">' . esc_attr($country_name); ?>
															</div>
														<?php endif; ?>
													</td>
												</tr>
												<tr>
													<td><?php esc_html_e('Past Teams:', 'splash'); ?></td>
													<td><?php echo implode(", ", $pastTeamsList); ?></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				endif;
			endforeach; ?>
		</div>
	</div>
<?php endif; ?>