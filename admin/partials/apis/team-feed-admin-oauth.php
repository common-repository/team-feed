<?php
/**
 * Provide an oauth API for the admin widget
 *
 * This file is used to the admin-oauth API aspects of the admin widget.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin/partials/apis
 */

    // Check Client_id is valid and oauth
	if( isset( $client_id ) && $client_id != 0 ){

		$url = "https://slack.com/oauth/reflow?scope=client&client_id=".$client_id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		// Check client id and update check client id option
		if($result == "OAuth Error: invalid_client_id"){
			?>
			<div style="background-color: #efb3b7; width: 400px; height: 25px; margin-top: 8px;">
				<p style="padding-left: 8px;">
					<?php print_r("invalid client_id, please type correct client_id"); ?>
				</p>
			</div>
			<?php

			// Update check client id with false
			update_option ( $this->plugin_option_name . '_check_client_id', "false"  , $autoload = 'yes' );
		} else{

			// Update check client id with true
			update_option ( $this->plugin_option_name . '_check_client_id',  "true" , $autoload = 'yes' );
		}
	}