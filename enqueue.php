<?php

/**
 * Enqueue.
 *
 * @package wp-mail-manager
 */

namespace BDAMailExtension;

add_action( 'admin_enqueue_scripts', 'BDAMailExtension\wp_mail_manager_admin_enqueue_static' );
function wp_mail_manager_admin_enqueue_static() {
	wp_mail_manager_enqueue_styles();
	wp_mail_manager_enqueue_scripts();
}


add_action( 'wp_enqueue_scripts', 'BDAMailExtension\wp_mail_manager_public_enqueue_static' );
function wp_mail_manager_public_enqueue_static() {
	if ( is_admin_bar_showing() ) {
		wp_mail_manager_enqueue_styles();
		wp_mail_manager_enqueue_scripts();
	}
}


function wp_mail_manager_enqueue_styles() {

	foreach ( glob( __DIR__ . '/app/build/static/css/*.css' ) as $file ) {
		// $file contains the name and extension of the file
		$filename = substr( $file, strrpos( $file, '/' ) + 1 );
		wp_enqueue_style(
			$filename,
			plugins_url( 'app/build/static/css/' . $filename, __FILE__ ),
			array(),
			BDA_MAIL_EXT_PLUGIN_VERSION
		);
	}

	wp_enqueue_style( 'wp-mail-manager', BDA_MAIL_EXT_PLUGIN_URL . '/admin/css/wp-mail-manager-admin.css', array(), BDA_MAIL_EXT_PLUGIN_VERSION );

}

function wp_mail_manager_enqueue_scripts() {

	foreach ( glob( __DIR__ . '/app/build/static/js/*.js' ) as $key => $file ) {
		// $file contains the name and extension of the file
		$filename = substr( $file, strrpos( $file, '/' ) + 1 );
		wp_enqueue_script(
			$filename,
			plugins_url( 'app/build/static/js/' . $filename, __FILE__ ),
			array(),
			BDA_MAIL_EXT_PLUGIN_VERSION,
			true
		);

		if ( $key == 0 ) {
			wp_localize_script(
				$filename,
				'wpMailManagerI18n',
				array(
					'settingsHeaderH1'         => __( 'Manually Check Your PHP & SMTP Mail Status', 'wp-mail-manager' ),
					'newResultViewHeader1'     => __( 'Everything is fine', 'wp-mail-manager' ),
					'newResultViewSubheader1'  => __( 'No attention required', 'wp-mail-manager' ),
					'newResultViewNote1'       => __( 'It is important to note that just because the mail was accepted for delivery, it does NOT mean the mail will actually reach the intended destination.', 'wp-mail-manager' ),
					'newResultViewHeader2'     => __( 'PHP "mail" function does not exists', 'wp-mail-manager' ),
					'newResultViewHeader3'     => __( 'E-mails cannot be sent with PHP', 'wp-mail-manager' ),
					'newResultViewSubheader4'  => __( 'Please enter a valid email address', 'wp-mail-manager' ),
					'mailStatusFormEmailLabel' => __( 'Send test email to:', 'wp-mail-manager' ),
					'mailStatusFormSubmitText' => __( 'Check mail status', 'wp-mail-manager' ),
					'mailExists'               => __( 'is working', 'wp-mail-manager' ),
					'mailNotExists'            => __( "doesn't work", 'wp-mail-manager' ),
					'mailWorking'              => __( 'can be sent', 'wp-mail-manager' ),
					'mailNotWorking'           => __( 'cannot be sent', 'wp-mail-manager' ),
					'enabled'                  => __( 'enabled', 'wp-mail-manager' ),
					'disabled'                 => __( 'disabled', 'wp-mail-manager' ),
				)
			);
		}
	}

	wp_enqueue_script( 'wp-mail-manager', BDA_MAIL_EXT_PLUGIN_URL . '/admin/js/wp-mail-manager-admin.js', array( 'jquery' ), BDA_MAIL_EXT_PLUGIN_VERSION, true );

}
