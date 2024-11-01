
=== WP Mailing Status ===
Contributors: belovdigital
Donate link: https://www.paypal.me/codekomilfo
Tags: mail, smtp, php, server settings
Requires at least: 5.0
Tested up to: 6.1.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The WP Mailing Status plugin provides features to track & manually check mail server status on your server - php mail function and SMTP mailing.

== Description ==

The plugin checks the PHP mail() and wp_mail() functions and the ability to send e-mails through PHP or SMTP email functionality.

During installation, the plugin sends a test email to check the PHP mail functionality. If the sending is successful, the green indicator in the topbar of the admin panel lights up. If the sending is unsuccessful, then it lights up red. Then the sending is repeated at intervals of 1 day for regular monitoring of the status. You can also refresh it in real-time mode by clicking "Refresh status" icon.

There is also a manual test. The user can write any email address and send a test email.

More features to come, such as:
- SMTP configuration
- Extended settings for the email submission
- Emails log


== Installation ==

1. Install the plugin.
2. Activate the plugin through the "Plugins" menu in WordPress


== Screenshots ==

1. Back-end - plugin's page
2. Admin bar dropdown


== Changelog ==

= 1.0.4 =

- WP 6.1 compatibility added
- PHP 8.0 compatibility added
- Plugin name changed


= 1.0.3 =

- jQuery error from front-end has been removed


= 1.0.2 =

- bug fixes


= 1.0.1 =

- SMTP test status added to the plugin's dropdown in wp-admin bar
- refresh status button added
- manual test changed from mail() to wp_mail() function


= 1.0 =

Initial release
