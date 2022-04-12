<?php
/**
 * WP Dispensary Taxonomy - Ingredients
 *
 * This file is used to define the product ingredients taxonomy of the plugin.
 *
 * @link       https://www.wpdispensary.com
 * @since      4.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/taxonomies
 */


/**
 * Ingredients Taxonomy
 *
 * Adds the Ingredient taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_ingredients_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Ingredients', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Ingredient', 'singular name', 'wp-dispensary' ),
		'search_items'               => esc_html__( 'Search Ingredients', 'wp-dispensary' ),
		'popular_items'              => esc_html__( 'Popular Ingredients', 'wp-dispensary' ),
		'all_items'                  => esc_html__( 'All Ingredients', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => esc_html__( 'Edit Ingredient', 'wp-dispensary' ),
		'update_item'                => esc_html__( 'Update Ingredient', 'wp-dispensary' ),
		'add_new_item'               => esc_html__( 'Add New Ingredient', 'wp-dispensary' ),
		'new_item_name'              => esc_html__( 'New Ingredient Name', 'wp-dispensary' ),
		'separate_items_with_commas' => esc_html__( 'Separate ingredients with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove ingredients', 'wp-dispensary' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used ingredients', 'wp-dispensary' ),
		'not_found'                  => esc_html__( 'No ingredients found', 'wp-dispensary' ),
		'menu_name'                  => esc_html__( 'Ingredients', 'wp-dispensary' ),
	);

	register_taxonomy( 'ingredients', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'ingredient',
		),
	) );
}
add_action( 'init', 'wp_dispensary_ingredients_taxonomy', 0 );

