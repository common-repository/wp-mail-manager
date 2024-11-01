<div class="wrap">
	<div id="wp-mail-manager-settings">
	<div id="wp-mail-manager-app"></div>

	<div class="wp-mail-manager-content">
		<hr>

		<h2><?php echo __( 'What Does the WP Mailing Status plugin Do?', 'wp-mail-manager' ); ?></h2>
		<p><?php echo __( 'Using the WP Mailing Status you can check from the admin panel if the PHP <a href="https://www.php.net/manual/en/function.mail.php" target="_blank">mail()</a> function and <a href="https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol" target="_blank">SMTP</a> mailing are working correctly and determine if emails are being sent. Here is how you do that.', 'wp-mail-manager' ); ?></p>
		<p><b>1.</b> <?php echo __( 'Open the admin panel.', 'wp-mail-manager' ); ?></p>
		<p><b>2.</b> <?php echo __( 'Find the “Mail Status” top bar widget.', 'wp-mail-manager' ); ?></p>
		<p><b>3.</b> <?php echo __( 'If you see a green circle, it means the mail function is working correctly. A red circle means something is wrong.', 'wp-mail-manager' ); ?></p>
		<p><b>4.</b> <?php echo __( 'Hover your mouse over the widget for more information. A dropdown menu will appear. The menu contains three status messages, "refresh status" button and a link to this page.', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'The first line indicates the status of the PHP <a href="https://www.php.net/manual/en/function.mail.php" target="_blank">mail()</a> function. The text will be green if the function is working properly. The text will be red if something is wrong. ', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'The second line in the menu indicates whether you can currently send email. If the text "Emails can be sent with PHP" is green, it indicates you can. If the text is red, there is a problem.', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'The third line indicates if you use <a href="https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol" target="_blank">SMTP</a> for sending emails. If not, it means that all emails handled by php mail funcitonality only. We recommend to use <a href="https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol" target="_blank">SMTP</a>, this feature is coming soon as part of our plugin.', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'The fourth line is an active link that takes you to the "Manual Test Page” where you can verify that your PHP & SMTP email functions are working correctly. You can also reach this page by clicking the “WP & SMTP Mail” link on the sidebar of the admin panel.', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( '"Refresh status" icon is actually a button that you can click to refresh the statues in real-time.', 'wp-mail-manager' ); ?></p>
		<p><b>5.</b> <?php echo __( 'When you click through to the Manual Test Page you will see the email submission box. You can use this to check the send feature by emailing yourself. Simply enter your email address in the box and click “Check mail status”. Note: it tests both PHP <a href="https://www.php.net/manual/en/function.mail.php" target="_blank">mail()</a> and <a href="https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol" target="_blank">SMTP</a> mailing functionality.', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'If all is working properly you should receive the test mail in your inbox. (How long it takes to arrive will depend on the location of your server and the time it takes the email to pass through system checks.)', 'wp-mail-manager' ); ?></p>
		<p><?php echo __( 'Once the test email has passed the checks, the “Mail Status” indicator in the top bar will be updated. Green means all is well. Red means the system encountered a problem.', 'wp-mail-manager' ); ?></p>

		<p class="note"><?php echo __( 'Note: The plugin does not verify that the email was received. Only that it was sent properly.', 'wp-mail-manager' ); ?></p>
	</div>
	</div>
</div>
