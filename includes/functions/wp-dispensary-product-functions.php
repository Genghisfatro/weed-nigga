<?php
/**
 * The file that defines the product helper functions.
 *
 * @link       https://www.wpdispensary.com
 * @since      2.6
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/includes/functions
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'is_product' ) ) {
	/**
	 * Is_product - Returns true when viewing a single product.
	 *
	 * @return bool
	 */
	function is_product() {
		return is_singular( 'products' );
	}
}

/**
 * Update messages for product types.
 *
 * @since 2.5
 */
function wpd_product_updated_messages( $messages ) {
	global $post;

	// Product ID.
	$product_id = $post->ID;

  if ( 'products' === get_post_meta( $product_id, 'product_type', true ) ) {
      $messages['post'] = array(
          0 => '', // Unused. Messages start at index 1.
          1 => sprintf( __( 'Product updated. <a href="%s">View product</a>' ), esc_url( get_permalink( $product_id ) ) ),
          2 => __( 'Product updated.', 'wp-dispensary' ),
          3 => __( 'Product deleted.', 'wp-dispensary' ),
          4 => __( 'Product updated.', 'wp-dispensary' ),
          5 => isset( $_GET['revision'] ) ? sprintf( __( 'Product restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
          6 => sprintf( __( 'Product published. <a href="%s">View product</a>' ), esc_url( get_permalink( $product_id ) ) ),
          7 => __( 'Product saved.', 'wp-dispensary' ),
          8 => sprintf( __( 'Product submitted. <a target="_blank" href="%s">Preview product</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $product_id ) ) ) ),
          9 => sprintf( __( 'Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>' ),
          date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $product_id ) ) ),
          10 => sprintf( __( 'Product draft updated. <a target="_blank" href="%s">Preview product</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $product_id ) ) ) ),
      );
  } else {
		// Do nothing.
	}
  return $messages;
}
add_filter( 'post_updated_messages', 'wpd_product_updated_messages' );

/**
 * Product Details
 *
 * Get the details of products based on specific paramaters
 *
 * @param  string $product_id
 * @param  array  $product_details
 * @param  string $wrapper
 * @return void
 */
function get_wpd_product_details( $product_id, $product_details, $wrapper ) {

    $str = '';

	// Create variable.
	$compounds_new = array();

	if ( isset( $wrapper ) ) {
		$wrapper = $wrapper;
	} else {
		$wrapper = 'span';
	}

    // Loop through required product details.
    foreach ( $product_details as $product=>$value ) {

		if ( 'show' === $value && 'thc' === $product ) {
			$compounds_new[] = 'thc';
		}

		if ( 'show' === $value && 'cbd' === $product ) {
			$compounds_new[] = 'cbd';
		}

		if ( 'show' === $value && 'thca' === $product ) {
			$compounds_new[] = 'thca';
		}

		if ( 'show' === $value && 'cba' === $product ) {
			$compounds_new[] = 'cba';
		}

		if ( 'show' === $value && 'cbn' === $product ) {
			$compounds_new[] = 'cbn';
		}

		if ( 'show' === $value && 'cbg' === $product ) {
			$compounds_new[] = 'cbg';
		}

    }

    // Get compounds.
	$compounds = get_wpd_compounds_simple( $product_id, NULL, $compounds_new );

    // Add compounds.
    $str .= $compounds;

    // Loop through required product details.
    foreach ( $product_details as $product=>$value ) {

			// Total THC (Servings X THC).
			if ( 'show' === $value && 'total_thc' === $product ) {
				if ( '' != get_post_meta( $product_id, '_thcmg', true ) && '' != get_post_meta( $product_id, '_thccbdservings', true ) ) {
					$str .= '<'  . $wrapper . ' class="wpd-productinfo thc"><strong>' . esc_attr__( 'THC', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_thcmg', true ) * get_post_meta( $product_id, '_thccbdservings', true ) . 'mg</'  . $wrapper . '>';
				} else {
					// Do nothing.
				}
			} else {
          // Do nothing.
			}

			// Seed count.
			if ( 'show' === $value && 'seed_count' === $product ) {
        if ( get_post_meta( $product_id, 'seed_count', true ) ) {
            $str .= '<'  . $wrapper . ' class="wpd-productinfo seeds"><strong>' . esc_attr__( 'Seeds', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, 'seed_count', true ) . '</'  . $wrapper . '>';
				} else {
					// Do nothing.
				}
			} else {
          // Do nothing.
			}

			// Clone count.
			if ( 'show' === $value && 'clone_count' === $product ) {
        if ( get_post_meta( $product_id, 'clone_count', true ) ) {
            $str .= '<'  . $wrapper . ' class="wpd-productinfo clones"><strong>' . esc_attr__( 'Clones', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, 'clone_count', true ) . '</'  . $wrapper . '>';
				} else {
					// Do nothing.
				}
			} else {
          // Do nothing.
			}

		// Size oz (Topicals).
		if ( 'show' === $value && 'size' === $product ) {
	        if ( get_post_meta( $product_id, '_sizetopical', true ) ) {
		$str .= '<'  . $wrapper . ' class="wpd-productinfo size"><strong>' . esc_attr__( 'Size', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_sizetopical', true ) . 'oz</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
			// Do nothing.
		}

		// THC mg (Topicals).
		if ( 'show' === $value && 'thc_topical' === $product ) {
			if ( get_post_meta( $product_id, '_thctopical', true ) ) {
				$str .= '<'  . $wrapper . ' class="wpd-productinfo thc"><strong>' . esc_attr__( 'THC', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_thctopical', true ) . 'mg</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
          // Do nothing.
		}

	    // CBD mg (Topicals).
		if ( 'show' === $value && 'cbd' === $product ) {
			if ( get_post_meta( $product_id, '_cbdtopical', true ) ) {
				$str .= '<'  . $wrapper . ' class="wpd-productinfo cbd"><strong>' . esc_attr__( 'CBD', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_cbdtopical', true ) . 'mg</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
			// Do nothing.
		}

		// Pre-roll weight.
		if ( 'show' === $value && 'weight' === $product ) {
			if ( get_post_meta( $product_id, '_preroll_weight', true ) ) {
				$str .= '<'  . $wrapper . ' class="wpd-productinfo weight"><strong>' . esc_attr__( 'Weight', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_preroll_weight', true ) . 'g</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
	        // Do nothing.
		}

		// THC mg (Edibles).
		if ( 'show' === $value && 'thcmg' === $product ) {
	        if ( get_post_meta( $product_id, '_thcmg', true ) ) {
				$str .= '<'  . $wrapper . ' class="wpd-productinfo thc"><strong>' . esc_attr__( 'THC', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_thcmg', true ) . 'mg</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
			// Do nothing.
		}

	    // Servings (Edibles).
		if ( 'show' === $value && 'servings' === $product ) {
	      if ( get_post_meta( $product_id, '_thccbdservings', true ) ) {
	          $str .= '<'  . $wrapper . ' class="wpd-productinfo servings"><strong>' . esc_attr__( 'Servings', 'wp-dispensary' ) . ':</strong> ' . get_post_meta( $product_id, '_thccbdservings', true ) . '</'  . $wrapper . '>';
			} else {
				// Do nothing.
			}
		} else {
			// Do nothing.
		}

    }

    return $str;

}

/**
 * Product Details
 *
 * Get the details of products based on specific paramaters
 *
 * @param  string $product_id
 * @param  array  $product_details
 * @param  string $wrapper
 * @return void
 */
function wpd_product_details( $product_id, $product_details, $wrapper ) {
    echo apply_filters( 'wpd_product_details', get_wpd_product_details( $product_id, $product_details, $wrapper ) );
}

/**
 * Product Image
 *
 * Get the featured image of the product
 *
 * @param  string $product_id
 * @param  string  $image_size
 * @return void
 */
function get_wpd_product_image( $product_id = NULL, $image_size ) {

    // Set product ID.
    if ( NULL === $product_id ) {
        $prod_id = get_the_ID();
    } else {
        $prod_id = $product_id;
    }

    // Set image size.
    if ( NULL === $image_size ) {
        $img_size = 'dispensary-image';
    } else {
        $img_size = $image_size;
    }

	$thumbnail_id        = get_post_thumbnail_id( $prod_id );
    $thumbnail_url_array = wp_get_attachment_image_src( $thumbnail_id, $img_size, false );
    $thumbnail_url       = $thumbnail_url_array[0];

    // Show image.
    if ( null === $thumbnail_url && 'full' === $image_size ) {
        $default_url = site_url() . '/wp-content/plugins/wp-dispensary/public/assets/images/wpd-large.jpg';
        $default_img = apply_filters( 'wpd_shortcodes_default_image', $default_url );
        $show_image  = '<a href="' . get_permalink( $product_id ) . '"><img src="' . $default_img . '" alt="' . get_the_title() . '" /></a>';
    } elseif ( null !== $thumbnail_url ) {
        $show_image = '<a href="' . get_permalink( $product_id ) . '"><img src="' . $thumbnail_url . '" alt="' . get_the_title() . '" /></a>';
    } else {
        $default_url = site_url() . '/wp-content/plugins/wp-dispensary/public/assets/images/' . $image_size . '.jpg';
        $default_img = apply_filters( 'wpd_shortcodes_default_image', $default_url );
        $show_image  = '<a href="' . get_permalink( $product_id ) . '"><img src="' . $default_img . '" alt="' . get_the_title() . '" /></a>';
    }

    return $show_image;
}

/**
 * Product image
 *
 * @since 2.6
 * @return string
 */
function wpd_product_image( $product_id, $image_size ) {
    echo apply_filters( 'wpd_product_image', get_wpd_product_image( $product_id, $image_size ) );
}

/**
 * Get all featured image sizes
 *
 * @since    3.0
 * @return   array
 */
function wpd_featured_image_sizes() {
	$image_sizes = array(
		'wpdispensary-widget',
		'dispensary-image',
		'wpd-thumbnail',
		'wpd-small',
		'wpd-medium',
		'wpd-large',
	);
	return apply_filters( 'wpd_featured_image_sizes', $image_sizes );
}

/**
 * Product Compound type
 * 
 * @param string $product_id
 * @since  4.0
 * @return void|string
 */
function wpd_compound_type( $product_id ) {
	// Bail early?
	if ( ! $product_id ) { return; }
	// Get post type.
	$product_type = get_post_meta( $product_id, 'product_type', true );
	// Set % compound type.
	if ( 'flowers' == $product_type || 'concentrates' == $product_type || 'prerolls' == $product_type || 'tinctures' == $product_type ) {
		$type = '%';
	}
	// Set mg compound type.
	if ( 'edibles' == $product_type || 'topicals' == $product_type ) {
		$type = 'mg';
	}
	// Default return.
	if ( ! $type ) {
		return '';
	}
	// Return type.
	return $type;
}

/**
 * Compounds details - Simple
 *
 * @see get_wpd_compounds_simple()
 * @since 2.5
 * @return string
 */
function wpd_compounds_simple( $product_id, $type = NULL, $compound_array = NULL ) {
    // Filters the displayed compound details.
    echo esc_html( apply_filters( 'wpd_compounds_simple', get_wpd_compounds_simple( $product_id, $type, $compound_array ) ) );
}

/**
 * Compounds details - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_compounds_simple( $product_id, $type = NULL, $compound_array = NULL ) {
	// Set compound type.
	if ( $type ) {
		$type = $type;
	} else {
		$type = NULL;
	}

	// Get post type.
	$product_type = get_post_meta( $product_id, 'product_type', true );

    // Create post type variables.
    if ( $product_type ) {
        $product_type_data = get_post_type_object( $product_type );
        $product_type_name = $product_type_data->label;
        $product_type_slug = $product_type_data->rewrite['slug'];
	}

	if ( 'flowers' == $product_type || 'concentrates' == $product_type || 'prerolls' == $product_type || 'tinctures' == $product_type ) {
		$type = '%';
	}

	if ( 'edibles' == $product_type || 'topicals' == $product_type ) {
		$type = 'mg';
	}

	// Set compounds.
	$compounds = array();

	// THC.
	if ( NULL != $compound_array && in_array( 'thc', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_thc', true ) ) {
			$compounds['THC'] = get_post_meta( $product_id, 'compound_thc', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// THCA.
	if ( NULL != $compound_array && in_array( 'thca', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_thca', true ) ) {
			$compounds['THCA'] = get_post_meta( $product_id, 'compound_thca', true ) . $type;
		}
	} else {
		// Do nothing.
	}

	// CBD.
	if ( NULL != $compound_array && in_array( 'cbd', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbd', true ) ) {
			$compounds['CBD'] = get_post_meta( $product_id, 'compound_cbd', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBA.
	if ( NULL != $compound_array && in_array( 'cba', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cba', true ) ) {
			$compounds['CBA'] = get_post_meta( $product_id, 'compound_cba', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBN.
	if ( NULL != $compound_array && in_array( 'cbn', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbn', true ) ) {
			$compounds['CBN'] = get_post_meta( $product_id, 'compound_cbn', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBG.
	if ( NULL != $compound_array && in_array( 'cbg', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbg', true ) ) {
			$compounds['CBG'] = get_post_meta( $product_id, 'compound_cbg', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// Create empty variable.
	$str = '';

	// Add each compound to variable.
	foreach ( $compounds as $compound=>$value ) {
		$str .= '<span class="wpd-productinfo ' . $compound . '"><strong>' . $compound . ':</strong> ' . $value . '</span>';
	}

	return $str;
}

/**
 * Compounds details - Array
 *
 * @see get_wpd_compounds_array()
 * @since 2.5
 * @return string
 */
function wpd_compounds_array( $product_id, $type = NULL, $compound_array = NULL ) {
    // Filters the displayed compounds.
    echo esc_html( apply_filters( 'wpd_compounds_array', get_wpd_compounds_array( $product_id, $type, $compound_array ) ) );
}


/**
 * Compounds details - Get Array
 *
 * @since 2.5
 * @return string
 */
function get_wpd_compounds_array( $product_id, $type = NULL, $compound_array = NULL ) {
	// Set compound type.
	if ( $type ) {
		$type = $type;
	} else {
		$type = NULL;
	}

	// Get post type.
	$product_type = get_post_meta( $product_id, 'product_type', true );

	if ( 'flowers' == $product_type || 'concentrates' == $product_type || 'prerolls' == $product_type || 'tinctures' == $product_type ) {
		$type = '%';
	}

	if ( 'edibles' == $product_type || 'topicals' == $product_type ) {
		$type = 'mg';
	}

	// Set compounds.
	$compounds = array();

	// THC.
	if ( in_array( 'thc', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_thc', true ) ) {
			$compounds['THC'] = get_post_meta( $product_id, 'compound_thc', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// THCA.
	if ( in_array( 'thca', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_thca', true ) ) {
			$compounds['THCA'] = get_post_meta( $product_id, 'compound_thca', true ) . $type;
		}
	} else {
		// Do nothing.
	}

	// CBD.
	if ( in_array( 'cbd', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbd', true ) ) {
			$compounds['CBD'] = get_post_meta( $product_id, 'compound_cbd', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBA.
	if ( in_array( 'cba', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cba', true ) ) {
			$compounds['CBA'] = get_post_meta( $product_id, 'compound_cba', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBN.
	if ( in_array( 'cbn', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbn', true ) ) {
			$compounds['CBN'] = get_post_meta( $product_id, 'compound_cbn', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	// CBG.
	if ( in_array( 'cbg', $compound_array ) ) {
		if ( get_post_meta( $product_id, 'compound_cbg', true ) ) {
			$compounds['CBG'] = get_post_meta( $product_id, 'compound_cbg', true ) . $type;
		} else {
			// Do nothing.
		}
	} else {
		// Do nothing.
	}

	return $compounds;
}

/**
 * Get all flower weights.
 *
 * @since 2.5.2
 * @return array
 */
function wpd_flowers_weights_array() {
	$flowers_weights = array(
		'1 g'    => 'price_gram',
		'2 g'    => 'price_two_grams',
		'1/8 oz' => 'price_eighth',
		'5 g'    => 'price_five_grams',
		'1/4 oz' => 'price_quarter_ounce',
		'1/2 oz' => 'price_half_ounce',
		'1 oz'   => 'price_ounce',
	);
	return apply_filters( 'wpd_flowers_weights_array', $flowers_weights );
}

/**
 * Get all concentrate weights.
 *
 * @since 2.5.2
 * @return array
 */
function wpd_concentrates_weights_array() {
	$concentrates_weights = array(
		'1/2 g' => 'price_half_gram',
		'1 g'   => 'price_gram',
		'2 g'   => 'price_two_grams',
	);
	return apply_filters( 'wpd_concentrates_weights_array', $concentrates_weights );
}
