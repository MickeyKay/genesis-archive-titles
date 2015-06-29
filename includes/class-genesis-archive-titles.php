<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://wordpress.org/plugins/genesis-archive-titles
 * @since      1.0.0
 *
 * @package    Genesis_Archive_Titles
 * @subpackage Genesis_Archive_Titles/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Genesis_Archive_Titles
 * @subpackage Genesis_Archive_Titles/includes
 * @author     MIGHTYminnow & Mickey Kay mickey@mickeykaycreative.com
 */
class Genesis_Archive_Titles {

	/**
	 * The main plugin file.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_file    The main plugin file.
	 */
	protected $plugin_file;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Genesis_Archive_Titles_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $slug    The string used to uniquely identify this plugin.
	 */
	protected $slug;

	/**
	 * The display name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $name    The plugin display name.
	 */
	protected $name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The instance of this class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Genesis_Archive_Titles    $instance    The instance of this class.
	 */
	private static $instance = null;

	/**
     * Creates or returns an instance of this class.
     *
     * @return    Genesis_Archive_Titles    A single instance of this class.
     */
    public static function get_instance( $args = array() ) {

        if ( null == self::$instance ) {
            self::$instance = new self( $args );
        }

        return self::$instance;

    }

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $args ) {

		$this->plugin_file = $args['plugin_file'];

		$this->slug = 'genesis-archive-titles';
		$this->name = __( 'Genesis Archive Titles', 'genesis-archive-titles' );
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shared_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Genesis_Archive_Titles_Loader. Orchestrates the hooks of the plugin.
	 * - Genesis_Archive_Titles_i18n. Defines internationalization functionality.
	 * - Genesis_Archive_Titles_Admin. Defines all hooks for the dashboard.
	 * - Genesis_Archive_Titles_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-genesis-archive-titles-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-genesis-archive-titles-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-genesis-archive-titles-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-genesis-archive-titles-public.php';

		$this->loader = new Genesis_Archive_Titles_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Genesis_Archive_Titles_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Genesis_Archive_Titles_i18n();
		$plugin_i18n->set_domain( $this->slug );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = Genesis_Archive_Titles_Admin::get_instance( $this );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = Genesis_Archive_Titles_Public::get_instance( $this );

		// Add archive title filter for main title.
		$this->loader->add_action( 'genesis_before', $plugin_public, 'add_archive_title_filter' );

		// Remove archive title filter for titles in the body.
		$this->loader->add_action( 'genesis_before_loop', $plugin_public, 'remove_archive_title_filter' );

	}

	/**
	 * Register all of the hooks related to both the admin and public-facing
	 * functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shared_hooks() {

		$plugin_shared = $this;

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Genesis_Archive_Titles_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Get any plugin property.
	 *
	 * @since     1.0.0
	 * @return    mixed    The plugin property.
	 */
	public function get( $property = '' ) {
		return $this->$property;
	}

}
