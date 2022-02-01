<?php
/**
 * WP Dispensary - Deprecated Taxonomies
 *
 * This file is used to define the deprecated categories taxonomy of the plugin.
 *
 * @link       https://www.wpdispensary.com
 * @since      4.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/deprecated
 */


/**
 * Product Categories Taxonomy
 *
 * Adds the default categories taxonomy to all custom post types
 *
 * @since    4.0
 */
function wp_dispensary_deprecated_categories() {

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'wp-dispensary' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'wp-dispensary' ),
		'search_items'      => __( 'Search Categories', 'wp-dispensary' ),
		'all_items'         => __( 'All Categories', 'wp-dispensary' ),
		'parent_item'       => __( 'Parent Category', 'wp-dispensary' ),
		'parent_item_colon' => __( 'Parent Category:', 'wp-dispensary' ),
		'edit_item'         => __( 'Edit Category', 'wp-dispensary' ),
		'update_item'       => __( 'Update Category', 'wp-dispensary' ),
		'add_new_item'      => __( 'Add New Category', 'wp-dispensary' ),
		'new_item_name'     => __( 'New Category Name', 'wp-dispensary' ),
		'not_found'         => __( 'No categories found', 'wp-dispensary' ),
		'menu_name'         => __( 'Categories', 'wp-dispensary' ),
	);

	register_taxonomy( 'flowers_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'flowers-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'concentrates_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'concentrates-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'edibles_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'edibles-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'topicals_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'topicals-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'growers_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'growers-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'wpd_gear_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'gear-category',
			'with_front' => true,
		),
	) );

	register_taxonomy( 'wpd_tinctures_category', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_in_rest'      => false,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'tinctures-category',
			'with_front' => true,
		),
	) );

}
add_action( 'init', 'wp_dispensary_deprecated_categories', 0 );
