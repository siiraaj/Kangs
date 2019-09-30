<?php
/*
Plugin Name: STM Importer
Plugin URI: http://stylemixthemes.com/
Description: STM Importer
Author: Stylemix Themes
Author URI: http://stylemixthemes.com/
Text Domain: stm_importer
Version: 2.6
*/

// Demo Import - Styles
function stm_demo_import_styles() {
	$plugin_url = plugin_dir_url( __FILE__ );

	wp_enqueue_style( 'stm-demo-import-style', $plugin_url . '/assets/css/style.css', null, null, 'all' );
}

add_action( 'admin_enqueue_scripts', 'stm_demo_import_styles' );

add_action('admin_menu', 'stm_add_demo_import_page');

if ( ! function_exists('stm_add_demo_import_page'))
{
	function stm_add_demo_import_page()
	{
		/*add_theme_page( esc_html__( 'STM Demo Import', 'splash' ) , esc_html__( 'STM Demo Import', 'splash' ) , 'manage_options' , 'stm_demo_import' , 'stm_demo_import' );*/
	}
}

if ( !function_exists('stm_demo_import'))
{
	function stm_demo_import()
	{
		?>
		<div class="stm_message content" style="display:none;">
			<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/spinner.gif" alt="spinner">
			<h1 class="stm_message_title"><?php esc_html_e('Importing Demo Content...', 'splash'); ?></h1>
			<p class="stm_message_text"><?php esc_html_e('Demo content import duration relies on your server speed.', 'splash'); ?></p>
		</div>

		<div class="stm_message success" style="display:none;">
			<p class="stm_message_text"><?php echo wp_kses( sprintf(__('Congratulations and enjoy <a href="%s" target="_blank">your website</a> now!', 'splash'), esc_url( home_url() )), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
		</div>

		<form class="stm_importer" id="import_demo_data_form" action="?page=stm_demo_import" method="post">

			<div class="stm_importer_options">

				<div class="stm_importer_note">
					<strong><?php esc_html_e('Before installing the demo content, please NOTE:', 'splash'); ?></strong>
					<p><?php echo wp_kses( sprintf(__('Install the demo content only on a clean WordPress. Use <a href="%s" target="_blank">Wordpress Database Reset</a> plugin to clean the current Theme.', 'splash'), 'http://wordpress.org/plugins/wordpress-database-reset/', esc_url( home_url() )), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
					<p><?php esc_html_e('Remember that you will NOT get the images from live demo due to copyright / license reason.', 'splash'); ?></p>
				</div>
				<div class="stm_demo_import_choices">
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-3.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="soccer" checked/>
							<?php esc_html_e('Soccer', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-1.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="basketball"/>
							<?php esc_html_e('Basketball', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-2.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="americanfootball"/>
							<?php esc_html_e('American Football', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-4.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="baseball"/>
							<?php esc_html_e('Baseball', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-5.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="magazine_one"/>
							<?php esc_html_e('Magazine One', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-6.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="magazine_two"/>
							<?php esc_html_e('Football Magazine', 'stm-importer'); ?>
						</span>
					</label>
					<label>
						<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/demo/demo-7.png" />
						<span class="stm_choice_radio_button">
							<input type="radio" name="splash_layout_demo" value="soccer_two"/>
							<?php esc_html_e('Soccer Two', 'stm-importer'); ?>
						</span>
					</label>
				</div>
				<input class="button-primary size_big" type="submit" value="Import" id="import_demo_data">

			</div>

		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#import_demo_data_form').on('submit', function() {
				    var layout = jQuery(this).find("input[name='splash_layout_demo']:checked").val();

					jQuery("html, body").animate({
						scrollTop: 0
					}, {
						duration: 300
					});
					jQuery('.stm_importer').slideUp(null, function(){
						jQuery('.stm_message.content').slideDown();
					});

					// Importing Content
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						data: jQuery(this).serialize()+'&action=stm_demo_import_content',
						success: function(){

							jQuery('.stm_message.content').slideUp();
							jQuery('.stm_message.success').slideDown();

                            jQuery.ajax({
                                url: 'https://panel.stylemixthemes.com/api/active/',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    theme: 'splash',
                                    layout: layout,
                                    website: "<?php echo esc_url(get_site_url()); ?>",

									<?php
									$envato = get_option('envato_market', array());
									$token = (!empty($envato['token'])) ? $envato['token'] : ''; ?>
                                    token: "<?php echo esc_js($token); ?>"
                                }
                            });

						}
					});
					return false;
				});
			});
		</script>
		<?php
	}

	// Content Import
	function stm_demo_import_content() {
		$splash_layout = 'basketball';

		if( !empty( $_POST['splash_layout_demo'] ) ) {
			$splash_layout = $_POST['splash_layout_demo'];
		}

		update_option('splash_layout', $splash_layout);

		set_time_limit( 0 );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if($splash_layout == 'basketball') {
			update_option('shop_catalog_image_size', array('width' => 570, 'height' => 350));
			update_option('shop_single_image_size', array('width' => 440, 'height' => 450));
			update_option('shop_thumbnail_image_size', array('width' => 100, 'height' => 89));

			add_image_size('shop_thumbnail', 100, 89, true);
			add_image_size('shop_catalog', 570, 350, true);
			add_image_size('shop_single', 440, 450, true);
		} elseif($splash_layout == 'soccer'){
			update_option('shop_catalog_image_size', array('width' => 350, 'height' => 350));
			update_option('shop_single_image_size', array('width' => 345, 'height' => 405));
			update_option('shop_thumbnail_image_size', array('width' => 110, 'height' => 110));
			
			add_image_size('shop_thumbnail', 110, 110, true);
			add_image_size('shop_catalog', 350, 350, true);
			add_image_size('shop_single', 345, 405, true);
		} elseif($splash_layout == 'baseball'){
			update_option('shop_catalog_image_size', array('width' => 300, 'height' => 300));
			update_option('shop_single_image_size', array('width' => 440, 'height' => 440));
			update_option('shop_thumbnail_image_size', array('width' => 440, 'height' => 440));

			add_image_size('shop_thumbnail', 440, 440, true);
			add_image_size('shop_catalog', 350, 350, true);
			add_image_size('shop_single', 440, 440, true);
		} else {
			update_option('shop_catalog_image_size', array('width' => 570, 'height' => 350));
			update_option('shop_single_image_size', array('width' => 358, 'height' => 488));
			update_option('shop_thumbnail_image_size', array('width' => 70, 'height' => 90));

			add_image_size('shop_thumbnail', 70, 90, true);
			add_image_size('shop_catalog', 570, 350, true);
			add_image_size('shop_single', 358, 488, true);
		}

		require_once( 'wordpress-importer/wordpress-importer.php' );

		$wp_import                    = new WP_Import();
		$wp_import->fetch_attachments = true;

		ob_start();
		$wp_import->import( get_template_directory() . '/includes/demo/'. $splash_layout .'/demo_content.xml' );
		ob_end_clean();
		
		set_transient('processed_posts', $wp_import->processed_posts, 1 * HOUR_IN_SECONDS);
		set_transient('processed_terms', $wp_import->processed_terms, 1 * HOUR_IN_SECONDS);

		do_action( 'splash_importer_done' );
		
		echo 'done';
		die();

	}

	add_action( 'wp_ajax_stm_demo_import_content', 'stm_demo_import_content' );

}
