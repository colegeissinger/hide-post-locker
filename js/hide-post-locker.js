jQuery(document).ready(function( $ ) {
	
	// Make sure our button actually exists...
	if ( $( '#post-lock-dialog' ).length === 1 ) {

		// Listen for a click to hide the post locker
		$( '.hide-post-locker-btn' ).click( function() {

			// Disable any actions a user can take...
			$( '#delete-action .submitdelete, #publishing-action #publish' ).attr( 'disabled', 'disabled' );

			// Remove the post lock dialog. Thanks to the Heartbeat API, we can't just hide it.
			// TODO: fix this up so we can reinvoke the post locker without a page refresh
			$( '#post-lock-dialog' ).remove();

			// Display our Preview message
			$( '.cg-hpl-preview-wrapper' ).fadeIn();

		});


		// Listen for a click on our show post locker link
		$( '.show-post-locker-btn' ).click( function() {

			// For now, we'll force a page refresh.
			location.reload();
		});
	}
});