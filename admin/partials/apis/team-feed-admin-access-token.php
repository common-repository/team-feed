<?php

/**
 * Provide an access token API for the plugin settings
 *
 * This file is used to the admin-access-token API aspects of the plugin.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin/partials/apis
 */


/*
 * Check if access_token an empty or not to use API
 */
$access_token = get_option( $this->plugin_option_name . '_access_token' );
if($access_token == "")
{
	if(isset($code) && $code != 0){

		$url = "https://slack.com/api/oauth.access?client_id=".$client_id."&scope=identify,read,post,client&client_secret=".$client_secret."&code=".$code;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);

		if($result['ok'] == 1){

			// Insert access token into wp_options
			$access_token = $result['access_token'];
			update_option ( $this->plugin_option_name . '_access_token',  $access_token , $autoload = 'yes' );

		} elseif($result['error'] == "bad_client_secret") {
			?>
				<div style="background-color: #efb3b7; width: 400px; height: 25px; margin-top: 8px;">
					<p style="padding-left: 8px;">
						<?php print_r(str_replace("_"," ",$result['error']).", please type correct client_secret"); ?>
					</p>
				</div>
			<?php
		} elseif($result['error'] != "invalid_client_id") {
			?>
				<div style="background-color: #efb3b7; width: 400px; height: 25px; margin-top: 8px;">
					<p style="padding-left: 8px;">
						<?php print_r(str_replace("_"," ",$result['error']).", please generate new code"); ?>
					</p>
				</div>
			<?php
		}
	}
}