<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://belovdigital.agency/
 * @since             1.0.0
 * @package           wp-mail-manager
 *
 * @wordpress-plugin
 * Plugin Name:       WP Mailing Status
 * Description:       Check the PHP mail() and wp_mail() functions and the ability to send e-mails for both methods - plain PHP and SMTP.
 * Version:           1.0.4
 * Author:            Belov Digital Agency
 * Author URI:        https://belovdigital.agency/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-mail-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}


/**
 * Helper constants
 */
define( 'BDA_MAIL_EXT_PLUGIN_DIR', rtrim( plugin_dir_path(__FILE__), '/' ) );
define( 'BDA_MAIL_EXT_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__), '/' ) );
define( 'BDA_MAIL_EXT_PLUGIN_VERSION', '1.0.4' );


/**
 * Plugin i18n
 */
// add_action( 'plugins_loaded', function(){
// 	load_plugin_textdomain( 'wp-mail-manager', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
// } );


/**
 * Require libraries
 */
require_once( plugin_dir_path( __FILE__ ) . '/libraries/action-scheduler/action-scheduler.php' );


/**
 * Require classes
 */
require __DIR__ . '/enqueue.php';
require __DIR__ . '/source/class-extensions.php';
require __DIR__ . '/source/class-setup.php';

$setup = new BDAMailExtension\Setup();

register_activation_hook( __FILE__, array( $setup, 'on_activation' ) );

register_deactivation_hook( __FILE__, array( $setup, 'on_deactivation' ) );
