<?php
add_filter('stm_nav_menu_item_additional_fields', 'mytheme_menu_item_additional_fields');
function mytheme_menu_item_additional_fields($fields)
{
    $fields['stm_mega'] = array(
        'name' => 'stm_mega',
        'label' => __('Megamenu type', 'splash'),
        'wrap' => 'stm_visible_lvl_0',
        'container_class' => 'stm_mega stm_megamenu_select',
        'input_type' => 'select',
        'options' => array(
            'disabled' => __('Disabled', 'splash'),
            'boxed' => __('Boxed', 'splash'),
            'wide' => __('Wide', 'splash'),
        )
    );

    $fields['stm_mega_cols'] = array(
        'name' => 'stm_mega_cols',
        'label' => __('Megamenu columns width', 'splash'),
        'wrap' => 'stm_visible_lvl_0',
        'container_class' => 'stm_mega_cols stm_megamenu_select',
        'input_type' => 'select',
        'options' => array(
            'default' => __('Default', 'splash'),
            '1' => '1 column - 1/12',
            '2' => '2 columns - 1/6',
            '3' => '3 columns - 1/4',
            '4' => '4 columns - 1/3',
            '5' => '5 columns - 5/12',
            '6' => '6 columns - 1/2',
            '7' => '7 columns - 7/12',
            '8' => '8 columns - 2/3',
            '9' => '9 columns - 3/4',
            '10' => '10 columns - 5/6',
            '11' => '11 columns - 11/12',
            '12' => '12 columns - 1/1',
        )
    );

    $fields['stm_mega_col_width'] = array(
        'name' => 'stm_mega_col_width',
        'label' => __('Megamenu column width', 'splash'),
        'wrap' => 'stm_visible_lvl_1',
        'container_class' => 'stm_mega_col_width stm_megamenu_select',
        'input_type' => 'select',
        'options' => array(
            'default' => __('Default', 'splash'),
            '1' => '1 column - 1/12',
            '2' => '2 columns - 1/6',
            '3' => '3 columns - 1/4',
            '4' => '4 columns - 1/3',
            '5' => '5 columns - 5/12',
            '6' => '6 columns - 1/2',
            '7' => '7 columns - 7/12',
            '8' => '8 columns - 2/3',
            '9' => '9 columns - 3/4',
            '10' => '10 columns - 5/6',
            '11' => '11 columns - 11/12',
            '12' => '12 columns - 1/1',
        )
    );

    $fields['stm_mega_cols_inside'] = array(
        'name' => 'stm_mega_cols_inside',
        'label' => __('Megamenu child columns width', 'splash'),
        'wrap' => 'stm_visible_lvl_1',
        'container_class' => 'stm_mega_cols_inside stm_megamenu_select',
        'input_type' => 'select',
        'options' => array(
            'default' => __('Default', 'splash'),
            '1' => '1 column - 1/12',
            '2' => '2 columns - 1/6',
            '3' => '3 columns - 1/4',
            '4' => '4 columns - 1/3',
            '5' => '5 columns - 5/12',
            '6' => '6 columns - 1/2',
            '7' => '7 columns - 7/12',
            '8' => '8 columns - 2/3',
            '9' => '9 columns - 3/4',
            '10' => '10 columns - 5/6',
            '11' => '11 columns - 11/12',
            '12' => '12 columns - 1/1',
        )
    );

    $fields['stm_mega_second_col_width'] = array(
        'name' => 'stm_mega_second_col_width',
        'label' => __('Megamenu column width', 'splash'),
        'wrap' => 'stm_visible_lvl_2',
        'container_class' => 'stm_mega_second_col_width stm_megamenu_select',
        'input_type' => 'select',
        'options' => array(
            'default' => __('Default', 'splash'),
            '1' => '1 column - 1/12',
            '2' => '2 columns - 1/6',
            '3' => '3 columns - 1/4',
            '4' => '4 columns - 1/3',
            '5' => '5 columns - 5/12',
            '6' => '6 columns - 1/2',
            '7' => '7 columns - 7/12',
            '8' => '8 columns - 2/3',
            '9' => '9 columns - 3/4',
            '10' => '10 columns - 5/6',
            '11' => '11 columns - 11/12',
            '12' => '12 columns - 1/1',
        )
    );

    $fields['stm_menu_logo'] = array(
        'name' => 'stm_menu_logo',
        'label' => __('Megamenu use logo', 'splash'),
        'wrap' => 'stm_visible_lvl_0',
        'container_class' => 'stm_menu_logo',
        'input_type' => 'stm_mega_logo',
    );

    $fields['stm_menu_icon'] = array(
        'name' => 'stm_menu_icon',
        'label' => __('Megamenu icon', 'splash'),
        'wrap' => 'stm_visible_lvl_1 stm_visible_lvl_2',
        'container_class' => 'stm_mega_icon',
        'input_type' => 'text',
    );

    $fields['stm_menu_image'] = array(
        'name' => 'stm_menu_image',
        'label' => __('Megamenu image', 'splash'),
        'new' => __('Add image', 'splash'),
        'delete' => __('Remove image', 'splash'),
        'replace' => __('Replace image', 'splash'),
        'wrap' => 'stm_visible_lvl_1 stm_visible_lvl_2',
        'container_class' => 'stm_mega_image',
        'input_type' => 'image',
    );

    $fields['stm_mega_textarea'] = array(
        'name' => 'stm_mega_textarea',
        'label' => __('Megamenu textarea', 'splash'),
        'wrap' => 'stm_visible_lvl_2',
        'container_class' => 'stm_mega_textarea',
        'input_type' => 'textarea',
    );

    $fields['stm_menu_bg'] = array(
        'name' => 'stm_menu_bg',
        'label' => __('Megamenu background', 'splash'),
        'new' => __('Add image', 'splash'),
        'delete' => __('Remove image', 'splash'),
        'replace' => __('Replace image', 'splash'),
        'wrap' => 'stm_visible_lvl_0',
        'container_class' => 'stm_menu_bg',
        'input_type' => 'image',
    );

	$fields['stm_mega_text_repeater'] = array(
		'name' => 'stm_mega_text_repeater',
		'label' => __('Megamenu text repeater', 'splash'),
		'wrap' => 'stm_visible_lvl_2',
		'container_class' => 'stm_mega_text_repeater',
		'input_type' => 'repeater',
	);


    return $fields;
}

if ( ! function_exists( 'splash_mm_get_menu_data' ) ) {
	function splash_mm_get_menu_data() {
		// Get event details
		$json           = array();
		$json['errors'] = array();

		$_POST['postId'] = filter_var( $_POST['postId'], FILTER_VALIDATE_INT );

		if ( empty( $_POST['postId'] ) ) {
			return false;
		}

		$menuIconData = get_post_meta($_POST['postId'], '_menu_item_stm_menu_icon_repeater');
		$menuTextData = get_post_meta($_POST['postId'], '_menu_item_stm_menu_text_repeater');

		$data = array('icons' => json_decode($menuIconData[0]), 'text' => json_decode($menuTextData[0]));

		echo json_encode( $data );
		exit;
	}
}

add_action( 'wp_ajax_splash_mm_get_menu_data', 'splash_mm_get_menu_data' );

add_action('admin_footer', 'setTemplateRepeater');
function setTemplateRepeater() {
	echo '<script id="repItem" type="text/template">
			<div class="mega-repeater-view">
				<input type="text" id="<%= icoId %>" class="widefat code edit-menu-item-stm_menu_icon_repeater" name="<%= icoName %>" value="<%= icoValue %>">
				<input type="text" id="<%= textId %>" class="widefat code edit-menu-item-stm_menu_text_repeater" name="<%= textName %>" value="<%= textValue %>">
				<div class="edit-menu-repeater-controls">
					<i class="fa fa-plus-square mm-plus" aria-hidden="true" data-id="<%= plusPosition %>"></i>
					<i class="fa fa-minus-square mm-minus" aria-hidden="true" data-id="<%= minusPosition %>"></i>
				</div>
			</div>				
		</script>';
}
