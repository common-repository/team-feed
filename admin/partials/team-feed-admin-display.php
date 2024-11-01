<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

	<div class="wrap">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<form action="options.php" method="post">
			<?php
				settings_fields( $this->plugin_name );
				do_settings_sections( $this->plugin_name );
				submit_button();
			?>

			<h1>Steps</h1>
			<h4>1- Create your Slack APP from <a href="https://api.slack.com/apps/new" target="_blank">Here </a> .</h4>
			<h4>You may populate the new app fields using this example: <a href="http://www.egirna.com/teamfeed#slackapp" target="_blank">Slack App</a></h4>
			<h3>Note:</h3><h4> Set this url "<?php echo site_url()."/wp-admin/options-general.php?page=team-feed"; ?>" in Redirect URI(s) field at slack app.</h4>
			<h4>2- Go to App Credentials in your slack app to get Client_id and Cleint_secret.</h4>
			<h4>3- Type Cleint_id and Cleint_secret from your app then click save.</h4>
			<h4>4- Click "Get your code" link to integrate with your team and get your code from redirect url.</h4>
			<h4>5- Type your code.</h4>
			<h4>6- save</h4>

		</form>
	</div>
