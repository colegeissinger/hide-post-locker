<?php

	/**
	 * The admin page! Pretty basic, just allows users to change the text in the plugin.
	 *
	 * @version 0.1
	 * @since   0.1
	 */


	/**
	 * Register the admin page with the 'admin_menu'
	 * @return void
	 *
	 * @version 0.1
	 * @since 	0.1
	 */
	function geissinger_setup_hpl_admin_menu() {
		$page = add_submenu_page( 'options-general.php', __( 'Hide Post Locker', 'geissinger-hpl' ), __( 'Hide Post Locker', 'geissinger-hpl' ), 'manage_options', 'hpl-options', 'geissinger_hpl_options', 99 );
	}
	add_action( 'admin_menu', 'geissinger_setup_hpl_admin_menu' );


	/**
	 * Load our HTML that will create the outter shell of the admin page
	 * @return HTML
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function geissinger_hpl_options() {

		// Check that the user is able to view this page.
		if ( ! current_user_can( 'manage_options' ) )
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'geissinger-hpl' ) ); ?>

		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e( 'Hide Post Locker Options', 'geissinger-hpl' ); ?></h2>

			<form action="options.php" method="post">
				<?php settings_fields( 'geissinger_hpl_message_options' ); ?>
				<?php do_settings_sections( 'geissinger_hpl_message_options' ); ?>
				<?php settings_fields( 'geissinger_hpl_preview_options' ); ?>
				<?php do_settings_sections( 'geissinger_hpl_preview_options' ); ?>
				<?php submit_button(); ?>
			</form>

		</div>
	<?php }


	/**
	 * Registers all of our sections and fields with the Settings API (http://codex.wordpress.org/Settings_API)
	 * @return void
	 *
	 * @version 0.1
	 * @since 	0.1
	 */
	function geissinger_init_hpl_settings_registration() {
		$option_name = 'geissinger_hpl_options';

		// Check if our settings options exist in the database. If not, add them.
		if ( get_option( 'geissinger_hpl_options' ) )
			add_option( 'geissinger_hpl_options' );

		/*** Settings Fields for 'geissinger_hpl_message_options' ***/
		add_settings_section( 'hpl_message_options', __( 'Message Window', 'geissinger-hpl' ), 'geissinger_hpl_message_options', 'geissinger_hpl_message_options' );

		// Settings Fields
		add_settings_field( 'locker_message_text', __( 'Message Text', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_message_options', 'hpl_message_options', array(
			'options-name' => $option_name,
			'id' 		   => 'message-text',
			'class' 	   => '',
			'value' 	   => '',
			'label' 	   => __( 'Change the text in the post locker messge. Defaults to "Want to preview the editor?"', 'geissinger-hpl' ),
		) );
		add_settings_field( 'locker_message_btn_text', __( 'Message Link Text', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_message_options', 'hpl_message_options', array(
			'options-name' => $option_name,
			'id'		   => 'message-btn-text',
			'class' 	   => '',
			'value'		   => '',
			'label'		   => __( 'Change the text in the link to hide the post locker window. Defaults to "Hide this window."', 'geissinger-hpl' ),
		) );
		add_settings_field( 'locker_message_classes', __( 'Add Custom Classes', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_message_options', 'hpl_message_options', array(
			'options-name' => $option_name,
			'id'		   => 'message-btn-class',
			'class' 	   => '',
			'value'		   => '',
			'label'		   => __( 'Add custom CSS classes for adding your own custom styles.', 'geissinger-hpl' ),
		) );


		/*** Settings Fields for 'geissinger_hpl_preview_options' ***/
		add_settings_section( 'hpl_preview_options', __( 'Preview Message Box', 'geissinger-hpl' ), 'geissinger_hpl_preview_options', 'geissinger_hpl_preview_options' );

		// Settings Fields
		add_settings_field( 'preview_title', __( 'Title', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_preview_options', 'hpl_preview_options', array(
			'options-name' => $option_name,
			'id' 		   => 'preview-title',
			'class' 	   => '',
			'value' 	   => '',
			'label' 	   => __( 'The text that is bolded and to the far left.', 'geissinger-hpl' ),
		) );
		add_settings_field( 'preview_text', __( 'Body Text', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_preview_options', 'hpl_preview_options', array(
			'options-name' => $option_name,
			'id' 		   => 'preview-text',
			'class' 	   => '',
			'value' 	   => '',
			'label' 	   => __( 'The main body text that is jsut to the right of the Title. Defaults to "Previewing Post Editor"', 'geissinger-hpl' ),
		) );
		add_settings_field( 'preview_btn_text', __( 'View Post Lock Link Text', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_preview_options', 'hpl_preview_options', array(
			'options-name' => $option_name,
			'id' 		   => 'preview-btn-text',
			'class' 	   => '',
			'value' 	   => '',
			'label' 	   => __( 'The text that is bolded and to the far left. Defaults to "Any edits made will not be saved as another user is currently editing."', 'geissinger-hpl' ),
		) );
		add_settings_field( 'preview_btn_class', __( 'View Post Lock Link Classes', 'geissinger-hpl' ), 'geissinger_settings_field_text', 'geissinger_hpl_preview_options', 'hpl_preview_options', array(
			'options-name' => $option_name,
			'id' 		   => 'preview-btn-class',
			'class' 	   => '',
			'value' 	   => '',
			'label' 	   => __( 'Add custom CSS classes for adding your own custom styles.', 'geissinger-hpl' ),
		) );


		// Register our settings with WordPress so we can save to the Database
		register_setting( 'geissinger_hpl_message_options', 'geissinger_hpl_options', 'geissinger_hpl_options_sanitize' );
		register_setting( 'geissinger_hpl_preview_options', 'geissinger_hpl_options', 'geissinger_hpl_options_sanitize' );
	}
	add_action( 'admin_init', 'geissinger_init_hpl_settings_registration' );


	/**
	 * This function is used in the add_settings_section() function for the theme options. Currently we have no data to really push here...
	 * @return void
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function geissinger_hpl_message_options() {
		echo '<p>' . __( 'Customize the text found in the Post Locker window', 'geissinger-hpl' ) . '.</p>';
	}


	/**
	 * This function is used in the add_settings_section() function for the widget options. Currently we have no data to really push here...
	 * @return void
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function geissinger_hpl_preview_options() {
		echo '<p>' . __( 'Customize the text in the Preview Message box', 'geissinger-hpl' ) . '.</p>';
	}


	/**
	 * The callback function to display our checkboxes
	 * @param  Array $args An array of our arguments passed in the add_settings_field() function
	 * @return HTML
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function geissinger_settings_field_text( $args ) {
		// Set the options-name value to a variable
		$name = $args['options-name'] . '[' . $args['id'] . ']';

		// Get the options from the database
		$options = get_option( $args['options-name'] ); ?>

		<input type="text" name="<?php echo $name; ?>" id="<?php echo $args['id']; ?>" <?php if ( ! empty( $args['class'] ) ) echo 'class="' . $args['class'] . '" '; ?>value="<?php echo ( ! empty( $options[ $args['id'] ] ) ) ? esc_attr( $options[ $args['id'] ] ) : ''; ?>" placeholder="<?php esc_attr_e( $args['value'] ); ?>" style="width:25%;" />
		<label for="<?php echo $args['id']; ?>"><?php esc_attr_e( $args['label'] ); ?></label>
	<?php }


	/**
	 * Our sanitization function. This will clean any entrees before submitted to the database.
	 * @param  String $input The data to be sanitized
	 * @return String
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function geissinger_hpl_options_sanitize( $input ) {

		// Set our array for the sanitized options
		$output = array();

		// Loop through each of our $input options and sanitize them.
		foreach ( $input as $key => $value ) {
			if ( isset( $input[ $key ] ) )
				$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
		}

		return apply_filters( 'geissinger_hpl_options_sanitize', $output, $input );
	}

