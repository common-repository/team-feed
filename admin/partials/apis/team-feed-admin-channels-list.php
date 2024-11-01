<?php
/**
 * Provide an channels list API for the admin widget
 *
 * This file is used to the admin-channels-list API aspects of the admin widget.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin/partials/apis
 */


	// Get channels list
	$url = "https://slack.com/api/channels.list?token=" . $instance['team_feed_token'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result = json_decode($result, true);

	if ($result['ok'] == true) {
		$instance['channel'] = array();
		$instance['channel'] = $result['channels'];
	} else {
		$result = "No Channels Found or invalid token";
		$instance['channel'] = $result;
	}
	curl_close($ch);