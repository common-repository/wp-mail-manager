<?php

/**
 * Setup.
 *
 * @package wp-mail-manager
 */

namespace BDAMailExtension;

use Exception;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

use WP_Post;

use WP_Query;

/**
 * The public-facing functionality of the plugin.
 */
class Extensions {
	/**
	 * The namespace to add to the api calls.
	 *
	 * @var string The namespace to add to the api call
	 */
	private $namespace;

	/**
	 * The REST API slug.
	 *
	 * @var string
	 */
	private $rest_api_slug = 'wp-json';

	/**
	 * Constructs the controller.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->namespace = 'bda-cli/v2';
		$this->rest_base = 'mail-extension';
	}

	/**
	 * Add the endpoints to the API
	 */
	public function register_rest_routes() {
		register_rest_route(
			$this->namespace,
			'get-mail-status',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_mail_status' ),
			)
		);
	}

	/**
	 * @param WP_REST_Request $request The request.
	 * @return WP_REST_Response The response.
	 */
	public function get_mail_status( WP_REST_Request $request = null, $external = true ) {
		$params = $request->get_query_params();

		$to = '';
		if ( isset( $params['to'] ) ) {
			$to = $params['to'];
		}

		if ( ( $to == null || $to == '' ) && $external ) {
			return new WP_REST_Response( __( 'Field "to" should be provided', 'wp-mail-manager' ), 400 );
		}

		if ( ( $to == null || $to == '' ) && ! $external ) {
			$to = 'tests@plugins.belovdigital.agency';
		}

		$mail_exists = function_exists( 'mail' );

		$subject = __( 'Mail check: test php mail() function', 'wp-mail-manager' );
		$message = __( 'If you received this email, the php mail() function on your website successfully sends emails.', 'wp-mail-manager' );

		$protocols = array( 'http://', 'http://www.', 'www.', 'https://', 'https://www.' );

		$sitename = str_replace( $protocols, '', site_url() );

		$headers  = "From: wp-mail-manager@$sitename\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();

		$mail_working = $mail_exists ? mail( $to, $subject, $message, $headers ) : false;

		// SMTP test
		set_transient( 'wp_mail_manager_send_wp_mail', true, 5 );
		$smtp_enabled    = false;
		$wp_mail_working = wp_mail(
			$to,
			__( 'Mail check: test SMTP', 'wp-mail-manager' ),
			__( 'If you received this email, the WordPress wp_mail() function on your website successfully sends emails. Current SMTP status can be visible in the top bar widget.', 'wp-mail-manager' )
		);
		if ( $wp_mail_working && get_transient( 'wp_mail_manager_mailer_is_smtp' ) ) {
			$smtp_enabled = true;
			update_option( 'bda_mail_is_smtp_enabled', '1' );
		}
		delete_transient( 'wp_mail_manager_mailer_is_smtp' );
		delete_transient( 'wp_mail_manager_send_wp_mail' );

		$result = array(
			'mailExists'  => $mail_exists,
			'mailWorking' => $mail_working,
			'smtpEnabled' => $smtp_enabled,
		);

		update_option( 'bda_mail_is_mail_exists', $mail_exists );
		update_option( 'bda_mail_is_mail_working', $mail_working );
		update_option( 'bda_mail_is_smtp_enabled', $smtp_enabled );

		return new WP_REST_Response( $result, 200 );
	}

	public function get_mail_status_async() {
		$response = $this->get_mail_status( new WP_REST_Request(), false );

		$mail_exists  = $response->data['mailExists'];
		$mail_working = $response->data['mailWorking'];
		$smtp_enabled = $response->data['smtpEnabled'];

		update_option( 'bda_mail_is_mail_exists', $mail_exists );
		update_option( 'bda_mail_is_mail_working', $mail_working );
		update_option( 'bda_mail_is_smtp_enabled', $smtp_enabled );
	}
}
