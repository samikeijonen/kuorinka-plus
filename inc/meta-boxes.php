<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add custom meta box for post types. You can filter that.
 *
 * @since 1.0.0
 * @return void
 */

 function kuorinka_plus_create_meta_boxes() {
 
	$kuorinka_plus_when_to_show = apply_filters( 'kuorinka_plus_show_metabox', array( 'post', 'page', 'portfolio_item' ) );
	
	foreach ( $kuorinka_plus_when_to_show as $kuorinka_plus_when_to_show_one ) {
		add_meta_box( 'kuorinka_plus_plugin_metabox', esc_html__( 'Soliloquy Slider in header', 'kuorinka-plus' ), 'kuorinka_plus_meta_box_display', $kuorinka_plus_when_to_show_one, 'side', 'core' );
	}
	
}
add_action( 'add_meta_boxes', 'kuorinka_plus_create_meta_boxes' );

/**
 * Displays the extra meta box.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $post
 * @param  array   $metabox
 * @return void
 */
function kuorinka_plus_meta_box_display( $post, $metabox ) {

	wp_nonce_field( basename( __FILE__ ), 'kuorinka-plus-plugin-metabox-nonce' );
	
	/* Retrieve metadata values if they already exist. */	
	$kuorinka_plus_slider_header = get_post_meta( $post->ID, '_kuorinka_plus_slider_header', true ); ?>
	
	<?php
	/* Get Soliloquy Sliders. */
	$kuorinka_plus_soliloquy_args = array(
		'post_type' 		=> 'soliloquy',
		'posts_per_page' 	=> -1
	);

	$kuorinka_plus_sliders = get_posts( $kuorinka_plus_soliloquy_args );
	?>
	
	<p>
		<select name="kuorinka_plus_slider_header">
		<option><?php _e( 'Select Slider', 'kuorinka-plus' ); ?></option>
		<?php

		/* Loop sliders data. */
		foreach ( $kuorinka_plus_sliders as $kuorinka_plus_slider ) { ?>
			<option value="<?php echo absint( $kuorinka_plus_slider->ID ) ?>" <?php selected( $kuorinka_plus_slider_header, absint( $kuorinka_plus_slider->ID ) ); ?>><?php echo esc_html( $kuorinka_plus_slider->post_title ); ?></option>
		
		<?php } ?>
		</select>
	</p>
	
	<?php
	
}

/**
 * Saves the metadata info meta box.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  object  $post
 * @return void
 */
function kuorinka_plus_save_meta_boxes( $post_id, $post ) {

	/* Check nonce. */
	if ( !isset( $_POST['kuorinka-plus-plugin-metabox-nonce'] ) || !wp_verify_nonce( $_POST['kuorinka-plus-plugin-metabox-nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	
	/* Check autosave. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$meta = array(
		'_kuorinka_plus_slider_header' => absint( $_POST['kuorinka_plus_slider_header'] )
	);

        foreach ( $meta as $meta_key => $new_meta_value ) {

                /* Get the meta value of the custom field key. */
                $meta_value = get_post_meta( $post_id, $meta_key, true );

                /* If there is no new meta value but an old value exists, delete it. */
                if ( current_user_can( 'edit_post', $post_id ) && '' == $new_meta_value && $meta_value )
                        delete_post_meta( $post_id, $meta_key, $meta_value );

                /* If a new meta value was added and there was no previous value, add it. */
                elseif ( current_user_can( 'edit_post', $post_id ) && $new_meta_value && '' == $meta_value )
                        add_post_meta( $post_id, $meta_key, $new_meta_value, true );

                /* If the new meta value does not match the old value, update it. */
                elseif ( current_user_can( 'edit_post', $post_id ) && $new_meta_value && $new_meta_value != $meta_value )
                        update_post_meta( $post_id, $meta_key, $new_meta_value );
        }
}
add_action( 'save_post', 'kuorinka_plus_save_meta_boxes', 10, 2 );
