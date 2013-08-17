<?php
	/*
		Plugin Name: Hide Post Locker
		Plugin URI: http://www.colegeissinger.com
		Description: Have the option to view a locked post's edit screen.
		Version: 0.1
		Author: Cole Geissinger
		Author URI: http://www.colegeissinger.com
		Text Domain: geissinger-hpl
		License: GPLv2 or later

		Copyright 2013 Cole Geissinger (cole@colegeissinger.com)

		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU General Public License
		as published by the Free Software Foundation; either version 2
		of the License, or (at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/

	class CG_Hide_Post_Locker {

		/**
		 * Set the plugins version for use within our code.
		 * @var string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private $version = '0.1';


		/**
		 * Our constructor. Any hooks, filters and other fun stuff goes here.
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function __construct() {

			// Enqueue our scriptzzzz
			add_action( 'admin_enqueue_scripts', array( $this, 'resources' ) );

			// Hook our custom button and text to the locker window
			add_action( 'post_locked_dialog', array( $this, 'hide_locker_message' ) );

			// Add in a custom box that displays at the top so we know we are view previewing the editor
			add_action( 'admin_footer', array( $this, 'add_preview_message' ) );
		}


		/**
		 * Load any JavaScript or CSS we need
		 * @return void
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function resources( $hook ) {
			
			// Only load this when we are viewing the post editor!
			if ( $hook != 'post.php' )
				return;

			// Load our styles
			wp_enqueue_style( 'geissinger-hpl-main-styles', plugins_url( 'css/hide-post-locker.css', __FILE__ ), null, $this->version );

			// Check if jQuery is already loaded. If not, load it! We'll just load WP's stock jQuery script.
			if ( ! wp_script_is( 'jquery' ) )
				wp_enqueue_script( 'jquery' );

			// Enqueue our custom script that makes the magix happen.
			wp_enqueue_script( 'geissinger-hpl-main-script', plugins_url( 'js/hide-post-locker.js', __FILE__ ), array( 'jquery' ), $this->version );
		}


		/**
		 * The function that contains the message to hide the login.
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function hide_locker_message() {

			// For easy customizations, allow users to over ride these messages.
			$content = array(
				'text' 		=> __( 'Want to preview the editor?', 'geissinger-hpl' ),
				'btn-text' 	=> __( 'Hide this window', 'geissinger-hpl' ),
				'btn-class' => '',
			);
			$options = apply_filters( 'geissinger-hpl-locker-content', $content );

			// Sanitize and display!
			echo wp_kses_post( $content['text'] ) . ' <a href="#" class="hide-post-locker-btn ' . esc_attr( $content['btn-class'] ) . '">' . wp_kses_post( $content['btn-text'] ) .'</a>';
		}


		/**
		 * Adds a block of content we can use to notify the user they are currently previewing the editor window
		 * and will not be able to save or make edits. Just preview.
		 * @return  string
		 * 
		 * @version 0.1
		 * @since   0.1
		 */
		public function add_preview_message() {

			// Make this filterable of course
			$content = array(
				'title' => __( 'Previewing Post Editor', 'geissinger-hpl' ),
				'text' => __( 'Any edits made will <strong>not</strong> be saved as another user is currently editing.', 'geissinger-hpl' ),
				'btn-text' => __( 'Display Post Locker', 'geissinger-hpl' ),
				'btn-class' => '',
			);
			$content = apply_filters( 'geissinger-hpl-preview-message', $content );

			// Output our HTML and content
			$output = '<div class="cg-hpl-preview-wrapper">';
				$output .= '<p><strong>' . wp_kses_post( $content['title'] ) . '</strong> - ' . wp_kses_post( $content['text'] ) . ' ';
				$output .= '<a href="#" class="show-post-locker-btn ' . esc_attr( $content['btn-clas'] ) . '">' . wp_kses_post( $content['btn-text'] ) . '</a></p>';
			$output .= '</div>';

			echo $output;
		}
	}

	$geissinger_hpl = new CG_Hide_Post_Locker();

	
	// Load our admin page so users can customize some things
	include_once( 'admin/post-locker-admin-page.php' );
		