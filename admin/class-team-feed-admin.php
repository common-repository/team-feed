<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/admin
 * @author     Egirna Technologies <info@egirna.com>
 */
class Team_Feed_Admin {

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
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$plugin_option_name 	Option name of this plugin
	 */
	private $plugin_option_name = 'team_feed';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Setting link beside Activate link
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		add_filter( 'plugin_action_links_'.$plugin_basename, array($this, 'team_feed_action_links') );

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/team-feed-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/team-feed-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('team_feed_admin', plugin_dir_url( __FILE__ ) . 'js/admin.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Create setting link beside Activate
	 *
	 * @since    1.0.0
	 */
	function team_feed_action_links( $links ) {
		$links[] = '<a href="' . admin_url( 'options-general.php?page=team-feed' ) . '">Settings</a>';
		return $links;
	}

	/**
	 * Create our custom team feed widget
	 *
	 * @since    1.0.0
	 */
	public function register_widgets() {

		register_widget( 'team_feed_widget' );
	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Team Feed Settings', 'team-feed' ),
			__( 'Team Feed', 'team-feed' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/team-feed-admin-display.php';
	}

	public function register_setting(){
		// Add a General section
		add_settings_section(
			$this->plugin_option_name . '_general',
			__( 'General', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->plugin_option_name . '_client_id',
			__( 'Client_Id', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_client_id_cb' ),
			$this->plugin_name,
			$this->plugin_option_name . '_general',
			array( 'label_for' => $this->plugin_option_name . '_client_id' )
		);

		add_settings_field(
			$this->plugin_option_name . '_client_secret',
			__( 'Client_Secret', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_client_secret_cb' ),
			$this->plugin_name,
			$this->plugin_option_name . '_general',
			array( 'label_for' => $this->plugin_option_name . '_client_secret' )
		);

		add_settings_field(
			$this->plugin_option_name . '_code',
			__( 'Code', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_code_cb' ),
			$this->plugin_name,
			$this->plugin_option_name . '_general',
			array( 'label_for' => $this->plugin_option_name . '_code' )
		);

		add_settings_field(
			$this->plugin_option_name . '_access_token',
			__( 'Access_Token', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_access_token_cb' ),
			$this->plugin_name,
			$this->plugin_option_name . '_general',
			array( 'label_for' => $this->plugin_option_name . '_access_token' )
		);

		add_settings_field(
			$this->plugin_option_name . '_check_client_id',
			__( '', 'team-feed' ),
			array( $this, $this->plugin_option_name . '_check_client_id_cb' ),
			$this->plugin_name,
			$this->plugin_option_name . '_general',
			array( 'label_for' => $this->plugin_option_name . '_check_client_id' )
		);

		// Sanitization callback
		register_setting( $this->plugin_name, $this->plugin_option_name . '_client_id' );
		register_setting( $this->plugin_name, $this->plugin_option_name . '_client_secret' );
		register_setting( $this->plugin_name, $this->plugin_option_name . '_code' );
		register_setting( $this->plugin_name, $this->plugin_option_name . '_access_token' );
		register_setting( $this->plugin_name, $this->plugin_option_name . '_check_client_id' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function team_feed_general_cb() {
		echo '<p>' . __( 'Please fill the settings accordingly.', 'team-feed' ) . '</p>';
	}

	/**
	* Render the text input field for client_id option
	*
	* @since  1.0.0
	*/
	public function team_feed_client_id_cb() {

		$client_id = get_option( $this->plugin_option_name . '_client_id' );
		echo '<input type="text" name="' . $this->plugin_option_name . '_client_id' . '" id="' . $this->plugin_option_name . '_client_id' . '" value="' . $client_id . '" style="width: 400px;" > ';

		// Oauth API file
		include plugin_dir_path( __FILE__ ) . 'partials/apis/team-feed-admin-oauth.php';
	}

	/**
	 * Render the text input field for client_secret option
	 *
	 * @since  1.0.0
	 */
	public function team_feed_client_secret_cb() {

		$client_secret = get_option( $this->plugin_option_name . '_client_secret' );
		echo '<input type="text" name="' . $this->plugin_option_name . '_client_secret' . '" id="' . $this->plugin_option_name . '_client_secret' . '" value="' . $client_secret . '" style="width: 400px;" > ';
	}

	/**
	 * Render the text input field for code option
	 *
	 * @since  1.0.0
	 */
	public function team_feed_code_cb() {

		// Get options values to activate code input
		$client_id     = get_option( $this->plugin_option_name . '_client_id' );
		$client_secret = get_option( $this->plugin_option_name . '_client_secret' );
		$code          = get_option( $this->plugin_option_name . '_code' );
		$check_client_id = get_option( $this->plugin_option_name . '_check_client_id' );

		// Show code API link if client_id , client_secret are set and check_client_id is true
		if ( ( isset( $client_id ) && $check_client_id == "true" ) && ( isset( $client_secret ) && $client_secret != "" ) ) {
			echo '<input type="text" name="' . $this->plugin_option_name . '_code' . '" id="' . $this->plugin_option_name . '_code' . '" value="' . $code . '" style="width: 400px;" > ';

			// Show the code link to get client code from slack API
			?>
			<a href="https://slack.com/oauth/authorize?scope=client&client_id=<?php print_r($client_id) ?>"
			   style="margin-left: 5px; text-decoration: none;">Get Your Code</a>
			<?php
		}
		else{
			echo '<input type="text" name="' . $this->plugin_option_name . '_code' . '" id="' . $this->plugin_option_name . '_code' . '" value="' . $code . '" style="width: 400px;" disabled="disabled" > ';
		}

		// Access token API file
		include plugin_dir_path( __FILE__ ) . 'partials/apis/team-feed-admin-access-token.php';
	}

	/**
	 * Render the text input field for access_token option
	 *
	 * @since  1.0.0
	 */
	public function team_feed_access_token_cb() {

		$access_token = get_option( $this->plugin_option_name . '_access_token' );
		echo '<input type="text" name="' . $this->plugin_option_name . '_access_token' . '" id="' . $this->plugin_option_name . '_access_token' . '" value="' . $access_token . '" style="width: 400px;" disabled="disabled" > ';
	}

	/**
	 * Render the hidden text input field for check_client_id option
	 *
	 * @since  1.0.0
	 */
	public function team_feed_check_client_id_cb() {

		$check_client_id = get_option( $this->plugin_option_name . '_check_client_id' );
		echo '<input type="hidden" name="' . $this->plugin_option_name . '_check_client_id' . '" id="' . $this->plugin_option_name . '_check_client_id' . '" value="' . $check_client_id . '"> ';
	}
}
