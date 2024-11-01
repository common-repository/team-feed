<?php
/**
 * Provide an channel history API for the public widget
 *
 * This file is used to the public-channel-history API aspects of the public widget.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/public/partials/apis
 */

	// Channel history API
	$url = "https://slack.com/api/channels.history?token=" . $instance['team_feed_token'] . "&channel=" . $instance['channel'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result = json_decode($result, true);

	if ($result['ok'] == true) {
		$instance['history'] = remove_json_row($result['messages'],$instance['team_feed_token']);
	} else {
		$result = "No history found or invalid data";
		$instance['history'] = $result;
	}
	curl_close($ch);

// Filtered function for json response
function remove_json_row($json,$token) {
	for($i = 0, $len = count($json); $i < $len; ++$i)
	{
		if (isset($json[$i]['subtype']) && $json[$i]['subtype'] == "channel_join")
		{
			// Array_splice($json, $i,1); //remove it
			unset($json[$i]);

		}elseif (isset($json[$i]['subtype']) && $json[$i]['subtype'] == "channel_leave")
		{
			// Array_splice($json, $i,1); //remove it
			unset($json[$i]);

		}elseif(isset($json[$i]['subtype']) && $json[$i]['subtype'] == "file_comment")
		{
			// Array_splice($json, $i,1); //remove it
			unset($json[$i]);

		}elseif(isset($json[$i]['subtype']) && $json[$i]['subtype'] == "bot_add")
		{
			// Array_splice($json, $i,1); //remove it
			unset($json[$i]);

		}elseif(isset($json[$i]['subtype']) && $json[$i]['subtype'] == "bot_message")
		{
			// Array_splice($json, $i,1); //remove it
			unset($json[$i]);
		}

		// Filter users
		if(isset($json[$i]['user'])){

			// Get user info
			$json[$i]['users'] = array();
			$url = "https://slack.com/api/users.info?token=".$token."&user=".$json[$i]['user']."&pretty=1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			$result = json_decode($result, true);

			// ALL users info
			array_push($json[$i]['users'],$result['user']);
		}

		// Make shared images public at all upload files
		if(isset($json[$i]['file']))
		{
			if($json[$i]['file']['public_url_shared'] == false)
			{
				// Get shared public url
				$url = "https://slack.com/api/files.sharedPublicURL?token=".$token. "&file=" . $json[$i]['file']['id'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$result = curl_exec($ch);
				$result = json_decode($result, true);

				// Replace private file with public shared file
				array_replace($json[$i]['file'],$result['file']);

				// Get public secret key to display images when user logged out from slack when public_url_shared is false
				$private_uri = $result['file']['url_private'];
				$secret_key = substr($result['file']['permalink_public'], strrpos($result['file']['permalink_public'], '-')+1);
				$pub_secret = "?pub_secret=".$secret_key;
				$json[$i]['file']['public_image_link'] = $private_uri.$pub_secret;

			} else{

				// Get public secret key to display images when user logged out from slack when public_url_shared is true
				$private_uri = $json[$i]['file']['url_private'];
				$secret_key = substr($json[$i]['file']['permalink_public'], strrpos($json[$i]['file']['permalink_public'], '-')+1);
				$pub_secret = "?pub_secret=".$secret_key;
				$json[$i]['file']['public_image_link'] = $private_uri.$pub_secret;
			}
		}
	}
	return $json;
}