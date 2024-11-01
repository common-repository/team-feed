<?php

/**
 * Our main team feed widget
 *
 *
 * @package    team-feed
 * @subpackage team-feed/widgets
 * @author     Egirna Technologies
 */

class team_feed_widget extends WP_Widget {

	// Sets up the widgets name etc.
	public function __construct()
	{
		// Instantiate the parent object.
		parent::__construct(
			'team_feed_widget',
			__('Team Feed', 'team_feed_widget'),
			array(
				'classname' => 'team_feed_widget',
				'description' => __('A List of Team Feed Channel(s)', 'team_feed_widget')
			)
		);
	}

	/* Front-end display of widget.
	 * @see WP_Widget::widget()
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		// Allow to access the values store in $args array
		extract($args, EXTR_SKIP);

		echo $before_widget;

		// Get team feed acces token form DB
		$access_token = get_option( 'team_feed_access_token' );

		$instance = wp_parse_args(
			(array)$instance,
			array(
				'team_feed_token' => $access_token
			)
		);

		include plugin_dir_path( __FILE__ ) . '../public/partials/team-feed-public-widget.php';

		echo $after_widget;
	}

	/* Back-end widget form.
	 * @see WP_Widget::form()
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		// Get team feed access token form DB
		$access_token = get_option( 'team_feed_access_token' );

		$instance = wp_parse_args(
			(array)$instance,
			array(
				'name' => '',
				'team_feed_token' => $access_token,
				'channel' => '',
				'history' => '',
				'channelId' => '',
				'channelName' => '',
			)
		);

		include plugin_dir_path( __FILE__ ) . '../admin/partials/team-feed-admin-widget.php';
	}

	/* Sanitize widget form values as they are saved.
	 * @see WP_Widget::update()
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
	{
		$old_instance['name'] = strip_tags(stripslashes($new_instance['name']));
		$old_instance['channel'] = strip_tags(stripslashes($new_instance['channel']));
		$old_instance['channelName'] = strip_tags(stripslashes($new_instance['channelName']));
		$old_instance['channelId'] = strip_tags(stripslashes($new_instance['channelId']));

		return $old_instance;
	}

}