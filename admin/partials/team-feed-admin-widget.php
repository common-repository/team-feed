<?php

/**
 * Provide a admin area view for the widget
 *
 * This file is used to markup the admin-facing aspects of the widget.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin/partials
 */

	$instance = wp_parse_args(
		(array)$instance,
		array(
			'channel' => ''
		)
	);

	// Channels list API file
	include plugin_dir_path( __FILE__ ) . 'apis/team-feed-admin-channels-list.php';

?>

<div class="slack_feed" xmlns="http://www.w3.org/1999/html">

	<div style="margin-bottom: 10px;">
		<label><?php _e('Widget Name:', 'team_feed_widget') ?></label><br/>
		<input type="text" id="<?php echo $this->get_field_id('name'); ?>"
		       name="<?php echo $this->get_field_name('name'); ?>"
		       value="<?php echo esc_attr($instance['name']); ?>"/>
	</div>

	<div style="margin-bottom: 10px;">
		<label><?php _e('Select Your Channel:', 'team_feed_widget') ?></label></br>
		<select id="<?php echo $this->get_field_id('channel'); ?>"
		        name="<?php echo $this->get_field_name('channel'); ?>"
		        class="team_feed_channel" onclick="SelectFunction()">

				<!-- If there is no channels or the token is invalid-->
			      <?php if ($instance['channel'] == "No Channels Found or invalid token"): ?>
				<option value="0"><?php echo $instance['channel'] ?></option>
			<?php endif; ?>

			<!-- Save channel id to keep current channel selected-->
			<?php $channelId = $instance['channelId']; ?>

			<?php foreach ($instance['channel'] as $channel): ?>
				<?php if ($channel['id'] == $channelId): ?>
					<option selected="selected" value="<?php echo $channel['id'] ?>"
					        name="<?php echo $channel['name'] ?>">
						<?php echo $channel['name'] ?>
					</option>
				<?php else : { ?>
					<option value="<?php echo $channel['id'] ?>"
					        name="<?php echo $channel['name'] ?>">
						<?php echo $channel['name'] ?>
					</option>
				<?php } ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>

		<input type="hidden" class="channelId" id="<?php echo $this->get_field_id('channelId'); ?>"
		       name="<?php echo $this->get_field_name('channelId'); ?>" value="<?php echo esc_attr($instance['channelId']); ?>"/>

		<input type="hidden" class="channelName" id="<?php echo $this->get_field_id('channelName'); ?>"
		       name="<?php echo $this->get_field_name('channelName'); ?>" value="<?php echo esc_attr($instance['channelName']); ?>"/>
	</div>
</div>
