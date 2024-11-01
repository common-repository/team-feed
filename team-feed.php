<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.egirna.com
 * @since             1.0.2
 * @package           Team_Feed
 *
 * @wordpress-plugin
 * Plugin Name:       Team Feed
 * Plugin URI:        http://www.egirna.com/teamfeed
 * Description:       Get your slack history channels and share comments, photos, videos and attachment files with your friends on your website widget sidebar
 * Version:           1.0.2
 * Author:            Egirna Technologies
 * Author URI:        http://www.egirna.com
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       team-feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-team-feed-activator.php
 */
function activate_team_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team-feed-activator.php';
	Team_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-team-feed-deactivator.php
 */
function deactivate_team_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team-feed-deactivator.php';
	Team_Feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_team_feed' );
register_deactivation_hook( __FILE__, 'deactivate_team_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-team-feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_team_feed() {

	$plugin = new Team_Feed();
	$plugin->run();

}
run_team_feed();
