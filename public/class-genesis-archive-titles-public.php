<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wordpress.org/plugins/genesis-archive-titles
 * @since      1.0.0
 *
 * @package    Genesis_Archive_Titles
 * @subpackage Genesis_Archive_Titles/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Genesis_Archive_Titles
 * @subpackage Genesis_Archive_Titles/public
 * @author     MIGHTYminnow & Mickey Kay mickey@mickeykaycreative.com
 */
class Genesis_Archive_Titles_Public {

	/**
	 * The main plugin instance.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Genesis_Archive_Titles    $plugin    The main plugin instance.
	 */
	private $plugin;

	/**
	 * The slug of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_slug    The slug of this plugin.
	 */
	private $plugin_slug;

	/**
	 * The display name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The plugin display name.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The instance of this class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Genesis_Archive_Titles_Public    $instance    The instance of this class.
	 */
	private static $instance = null;

	/**
     * Creates or returns an instance of this class.
     *
     * @return    Genesis_Archive_Titles_Public    A single instance of this class.
     */
    public static function get_instance( $plugin ) {

        if ( null == self::$instance ) {
            self::$instance = new self( $plugin );
        }

        return self::$instance;

    }

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_slug    The name of the plugin.
	 * @var      string    $version        The version of this plugin.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		$this->plugin_slug = $this->plugin->get( 'slug' );
		$this->plugin_name = $this->plugin->get( 'name' );
		$this->version = $this->plugin->get( 'version' );

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
		 * defined in Genesis_Archive_Titles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Genesis_Archive_Titles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_slug, plugin_dir_url( __FILE__ ) . 'css/genesis-archive-titles-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the scripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Genesis_Archive_Titles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Genesis_Archive_Titles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		//wp_enqueue_script( $this->plugin_slug, plugin_dir_url( __FILE__ ) . 'js/genesis-archive-titles-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_archive_titles() {

		if ( ! is_singular() ) {
			genesis_do_post_title();
		}

	}

	/**
	 * Add custom title filter for archives.
	 *
	 * @since 1.0.0
	 */
	public function add_archive_title_filter() {

		// Add title filter for archive pages.
		if ( ! is_singular() ) {
			add_filter( 'genesis_post_title_text', array( $this, 'get_custom_archive_titles' ) );
			add_filter( 'genesis_link_post_title', '__return_false' );
		}

	}

	/**
	 * Get custom archive titles.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Original title.
	 *
	 * @return string $title Updated title.
	 */
	function get_custom_archive_titles( $title ) {

		// Attempt to get the generic archive title.
		$title = get_the_archive_title();

		// Custom create blog page title.
		if ( is_front_page() || is_home() ) {
			$blog_page_id = get_option( 'page_for_posts' );
			$title = get_the_title( $blog_page_id );
		}

		// Don't do anything if, after all that, we just got the standard get_the_archive_title() return.
		if ( 'Archives' == $title ) {
			$title = '';
		}

		return $title;
	}

	/**
	 * Remove archive title filter after the first main title.
	 *
	 * @since    1.0.0
	 */
	function remove_archive_title_filter() {

		remove_filter( 'genesis_post_title_text', array( $this, 'get_custom_archive_titles' ) );
		add_filter( 'genesis_link_post_title', '__return_true' );

	}

}
