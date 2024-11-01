<?php

/**
 * Setup.
 *
 * @package wp-mail-manager
 */

namespace BDAMailExtension;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Setup.
 */
class Setup {
	/**
	 * @var Extensions
	 */
	private $extensions;

	/**
	 * Setup action & filter hooks.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'add_schedule_hooks' ) );

		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );

		add_action( 'admin_bar_menu', array( $this, 'add_top_link_to_admin_bar' ), 999 );

		$this->extensions = new Extensions();

		add_action( 'rest_api_init', array( $this->extensions, 'register_rest_routes' ) );

		add_action( 'bda_run_background_mail_status_check', array( $this->extensions, 'get_mail_status_async' ) );

		add_action( 'phpmailer_init', array( $this, 'check_phpmailer_configuration' ), 999 );
	}

	public function on_activation() {
		add_option( 'bda_mail_is_mail_exists', false );

		add_option( 'bda_mail_is_mail_working', false );

		add_option( 'bda_mail_is_smtp_enabled', false );

		$this->extensions->get_mail_status_async();
	}

	public function on_deactivation() {
		delete_option( 'bda_mail_is_mail_exists', false );

		delete_option( 'bda_mail_is_mail_working', false );

		delete_option( 'bda_mail_is_smtp_enabled', false );

		as_unschedule_all_actions( 'bda_run_background_mail_status_check' );
	}

	public function add_schedule_hooks() {
		if ( false === as_next_scheduled_action( 'bda_run_background_mail_status_check' ) ) {
			as_schedule_recurring_action( strtotime( 'tomorrow' ), DAY_IN_SECONDS, 'bda_run_background_mail_status_check' );
		}
	}

	public function plugin_menu() {
		add_menu_page( __( 'WP Mailing Status', 'wp-mail-manager' ), __( 'Mailing Status', 'wp-mail-manager' ), 'manage_options', 'wp-mail-manager', array( $this, 'plugin_options' ), 'dashicons-email-alt' );
	}

	public function plugin_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'wp-mail-manager' ) );
		}

		ob_start();
		include BDA_MAIL_EXT_PLUGIN_DIR . '/admin/partials/wp-mail-manager-admin-display.php';
		echo ob_get_clean();
	}

	public function add_top_link_to_admin_bar( $admin_bar ) {
		$mail_exists  = get_option( 'bda_mail_is_mail_exists' );
		$mail_working = get_option( 'bda_mail_is_mail_working' );
		$smtp_enabled = get_option( 'bda_mail_is_smtp_enabled' );

		if ( ! $mail_exists || ! $mail_working ) {
			$flashlight_state = 'not-ok';
		} else {
			$flashlight_state = 'ok';
		}

		if ( $mail_exists ) {
			$mail_exists_message = '<span class="ok">' . __( 'is working', 'wp-mail-manager' ) . '</span>';
		} else {
			$mail_exists_message = '<span class="not-ok">' . __( "doesn't work", 'wp-mail-manager' ) . '</span>';
		}

		if ( $mail_working ) {
			$mail_working_message = '<span class="ok">' . __( 'can be sent', 'wp-mail-manager' ) . '</span>';
		} else {
			$mail_working_message = '<span class="not-ok">' . __( 'cannot be sent', 'wp-mail-manager' ) . '</span>';
		}

		if ( $smtp_enabled ) {
			$smtp_enabled_message = '<span class="ok">' . __( 'enabled', 'wp-mail-manager' ) . '</span>';
		} else {
			$smtp_enabled_message = '<span class="not-ok">' . __( 'disabled', 'wp-mail-manager' ) . '</span>';
		}

		$args = array(
			'id'    => 'wp-mail-manager',
			'title' => __( 'Mail Status', 'wp-mail-manager' ) . sprintf( ' <span class="flashlight %s"></span>', $flashlight_state ),
		);
		$admin_bar->add_node( $args );

		$args = array(
			'parent' => 'wp-mail-manager',
			'id'     => 'wp-mail-manager-buttons',
			'title'  => '<button class="wp-mail-manager-refresh" type="button"><img src="' . BDA_MAIL_EXT_PLUGIN_URL . '/admin/images/refresh.svg"></button>',
			'meta'   => false,
		);
		$admin_bar->add_node( $args );

		$args = array(
			'parent' => 'wp-mail-manager',
			'id'     => 'wp-mail-manager-is-phpmail-exists',
			'title'  => __( 'PHP function mail()', 'wp-mail-manager' ) . ' ' . $mail_exists_message,
			'meta'   => false,
		);
		$admin_bar->add_node( $args );

		$args = array(
			'parent' => 'wp-mail-manager',
			'id'     => 'wp-mail-manager-is-phpmail-working',
			'title'  => __( 'E-mails', 'wp-mail-manager' ) . ' ' . $mail_working_message . ' ' . __( 'with PHP', 'wp-mail-manager' ),
			'meta'   => false,
		);
		$admin_bar->add_node( $args );

		$args = array(
			'parent' => 'wp-mail-manager',
			'id'     => 'wp-mail-manager-is-smtp-enabled',
			'title'  => __( 'SMTP', 'wp-mail-manager' ) . ' ' . $smtp_enabled_message,
			'meta'   => false,
		);
		$admin_bar->add_node( $args );

		if ( current_user_can( 'manage_options' ) ) {
			$args = array(
				'parent' => 'wp-mail-manager',
				'id'     => 'wp-mail-manager-manual-test',
				'title'  => __( 'Manual Test →', 'wp-mail-manager' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wp-mail-manager' ) ),
				'meta'   => false,
			);
			$admin_bar->add_node( $args );
		}

	}

	public function check_phpmailer_configuration( $phpmailer ) {
		if ( get_transient( 'wp_mail_manager_send_wp_mail' ) ) {
			if ( $phpmailer->Mailer != 'mail' ) {
				set_transient( 'wp_mail_manager_mailer_is_smtp', true, 60 );
			}
		}
	}

}
