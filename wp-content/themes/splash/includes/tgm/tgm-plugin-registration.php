<?php

require_once get_template_directory() . '/includes/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'stm_require_plugins' );

function stm_require_plugins() {
	$plugins_path = get_template_directory() . '/includes/tgm/plugins';
	$plugins = array(
		array(
			'name'               => 'STM Configurations',
			'slug'               => 'stm-configurations',
			'source'             => $plugins_path . '/stm-configurations.zip',
			'required'           => true,
			'force_activation'   => false,
			'version' => '2.4'
		),
        array(
            'name'               => 'STM Importer',
            'slug'               => 'stm_importer',
            'source'             => $plugins_path . '/stm_importer.zip',
            'required'           => false,
            'force_activation'   => false,
            'version'			 => '2.6'
        ),
        array(
            'name'               => 'WPBakery Visual Composer',
            'slug'               => 'js_composer',
            'source'             => $plugins_path . '/js_composer.zip',
            'required'           => true,
            'force_activation'   => false,
            'version'            => '5.6',
            'external_url'       => 'http://vc.wpbakery.com',
        ),
        array(
            'name'               => 'Revolution Slider',
            'slug'               => 'revslider',
            'source'             => $plugins_path . '/revslider.zip',
            'required'           => false,
            'version'            => '5.4.8.1',
            'external_url'       => 'http://www.themepunch.com/revolution/'
        ),
        array(
            'name'              => 'Breadcrumb NavXT',
            'slug'              => 'breadcrumb-navxt',
            'required'          => false,
            'force_activation'  => false,
        ),
        array(
            'name'              => 'Contact Form 7',
            'slug'              => 'contact-form-7',
            'required'          => false,
            'force_activation'  => false,
        ),
        array(
            'name'              => 'Woocommerce',
            'slug'              => 'woocommerce',
            'required'          => false,
            'force_activation'  => false,
        ),
        array(
            'name'              => 'SportsPress',
            'slug'              => 'sportspress',
            'required'          => true,
            'force_activation'  => false,
        ),
		array(
			'name'         => 'Instagram Feed',
			'slug'         => 'instagram-feed',
			'required'     => false,
			'external_url' => 'http://smashballoon.com/instagram-feed/'
		),
		array(
			'name'         => 'MailChimp for WordPress',
			'slug'         => 'mailchimp-for-wp',
			'required'     => false,
			'external_url' => 'https://mc4wp.com/'
		)
	);

	$config = array(
		'id' => 'tgm_message_update',
		'strings' => array(
			'nag_type' => 'update-nag'
		)
	);
	
	if (is_layout('af') || is_layout("sccr")) {
		$plugins[] = array(
			'name' => 'Latest Tweets Widget',
			'slug' => 'latest-tweets-widget',
			'required' => false,
			'external_url' => 'http://timwhitlock.info/'
		);
		$plugins[] = array(
			'name' => 'AddToAny Share Buttons',
			'slug' => 'add-to-any',
			'required' => false,
			'external_url' => 'https://www.addtoany.com/'
		);
	}

    if (is_layout('magazine_one')) {
            $plugins[] = array(
                'name' => 'AddToAny Share Buttons',
                'slug' => 'add-to-any',
                'required' => false,
                'external_url' => 'https://www.addtoany.com/'
            );
            $plugins[] = array(
                'name' => 'AccessPress Social Counter',
                'slug' => 'accesspress-social-counter',
                'required' => false,
                'external_url' => 'http://accesspressthemes.com'
            );
        }

	tgmpa( $plugins, $config );

}