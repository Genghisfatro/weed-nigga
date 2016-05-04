<?php
/**
 * Adding the Admin Settings Page
 *
 * @link       http://www.wpdispensary.com
 * @since      1.6.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Creating the menu item
 */
add_action( 'admin_menu', 'wpd_settings_add_admin_menu' );
add_action( 'admin_init', 'wpd_settings_init' );


/**
 * Adding the menu page
 */
function wpd_settings_add_admin_menu() {

	add_menu_page(
		'WP Dispensary',
		'WP Dispensary',
		'manage_options',
		'wp_dispensary',
		'wpd_settings_options_page',
		plugin_dir_url( __FILE__ ) . ( '/images/menu-icon.png' )
	);

}


/**
 * Adding settings init
 */

function wpd_settings_init() {

	register_setting( 'wpdsettings', 'wpd_settings_settings' );

	add_settings_section(
		'wpd_settings_wpdsettings_section', 
		__( 'WP Dispensary Settings', 'wp-dispensary' ), 
		'wpd_settings_subtitle_section_callback', 
		'wpdsettings'
	);

	add_settings_field(
		'wpd_settings_single_menu_output', 
		__( 'Hide single menu item details in public display?', 'wp-dispensary' ), 
		'wpd_settings_single_menu_output_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

}


/**
 * Add Function:
 * Single Menu Output
 */

function wpd_settings_single_menu_output_render() {

	$options = get_option( 'wpd_settings_settings' );
	?>
	<input type='checkbox' name='wpd_settings_settings[wpd_settings_single_menu_output]' <?php checked( $options['wpd_settings_single_menu_output'], 1 ); ?> value='1'>
	<?php

}


/**
 * Add Function:
 * Setting sub-title
 */

function wpd_settings_subtitle_section_callback(  ) { 

	echo __( '', 'wp-dispensary' );

}


/**
 * Add Function:
 * Settings option page display
 */

function wpd_settings_options_page(  ) { 

	?>
	<form action='options.php' method='post' class="wpd-settings">

		<?php
			settings_fields( 'wpdsettings' );
			do_settings_sections( 'wpdsettings' );
			submit_button();
		?>

	</form>
	<?php

}

?>