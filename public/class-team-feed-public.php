<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/public
 * @author     Egirna Technologies <info@egirna.com>
 */
class Team_Feed_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/team-feed-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'team_feed_widget', plugin_dir_url( __FILE__ ) . 'css/widget.css' , array(), $this->version, 'all');
		wp_enqueue_style( 'team_feed_widget_scroll', '//cdn.bootcss.com/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/team-feed-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'team_feed_widget', plugin_dir_url( __FILE__ ) . 'js/widget.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'team_feed_widget_continueReading', plugin_dir_url( __FILE__ ) . 'js/continue-reading.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'team_feed_widget_scroll', '//cdn.bootcss.com/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), $this->version, true );
	}

}
