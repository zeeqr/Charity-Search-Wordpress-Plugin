<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://facebook.com/humayoon.zahoor
 * @since      1.0.0
 *
 * @package    Hz_Api_Feed
 * @subpackage Hz_Api_Feed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Hz_Api_Feed
 * @subpackage Hz_Api_Feed/public
 * @author     Humayoon Zahoor <humayoon.zahoor@gmail.com>
 */
class Hz_Api_Feed_Public {

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
		add_action( 'rest_api_init',array($this,'register_api_routes'));
		add_shortcode( 'charity-commission', array($this,'shortcode_display') );

	}

	public function register_api_routes($attr){
		// Api Call for Charity search list
		register_rest_route( 'hz-feed/v1', '/search', array(
      array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'search_charities' )
      ) ) ); 
		
		// Api Call for Charity Detail
		register_rest_route( 'hz-feed/v1', '/view', array(
      array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'view_charity' )
      ) ) );
	}
	
	public function view_charity($data){
		$charityApi = new charity_api();
		if($id = $data->get_param('id'))
 		$result = $charityApi->getCharityDetail($id);
		
		return new WP_REST_Response( $result, 200 );
	}
	
	public function search_charities($data){
		$charityApi = new charity_api(); 
		if($k = $data->get_param('k'))
 		$result = $charityApi->searchByKeyword($k);
		
		if($n = $data->get_param('n'))
 		$result = $charityApi->searchByName($n);
		
		
		return new WP_REST_Response( $result, 200 );
	}
	
	// front end display
	public function shortcode_display($attr) {
		
	ob_start();
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/hz-api-feed-public-display.php';
	return ob_get_clean();
		
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
		 * defined in Hz_Api_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hz_Api_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hz-api-feed-public.css', array(), $this->version, 'all' );

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
		 * defined in Hz_Api_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hz_Api_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'-angular', plugin_dir_url( __FILE__ ) . 'js/angular.min.js', array( ), $this->version, false );
		
		
		//wp_enqueue_script( 'hz-ajax-script' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/app.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'hz_feed', array( 'ajax_url' => get_site_url(null, 'wp-json/hz-feed/v1/') ) );

	}

}
