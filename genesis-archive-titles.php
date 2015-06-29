<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wordpress.org/plugins/genesis-archive-titles
 * @since             1.0.0
 * @package           Genesis_Archive_Titles
 *
 * @wordpress-plugin
 * Plugin Name:       Genesis Archive Titles
 * Plugin URI:        http://wordpress.org/plugins/genesis-archive-titles
 * Description:       Auto generate titles for your Genesis archive pages (categories, tags, authors, etc).
 * Version:           1.0.0
 * Author:            MIGHTYminnow & Mickey Kay
 * Author URI:        http://mightyminnow.com/plugin-landing-page?utm_source=genesis-archive-titles&utm_medium=plugin-repo&utm_campaign=WordPress%20Plugins/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       genesis-archive-titles
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-genesis-archive-titles-activator.php
 */
function activate_genesis_archive_titles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-genesis-archive-titles-activator.php';
	Genesis_Archive_Titles_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-genesis-archive-titles-deactivator.php
 */
function deactivate_genesis_archive_titles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-genesis-archive-titles-deactivator.php';
	Genesis_Archive_Titles_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_genesis_archive_titles' );
register_deactivation_hook( __FILE__, 'deactivate_genesis_archive_titles' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-genesis-archive-titles.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_genesis_archive_titles() {

	// Pass main plugin file through to plugin class for later use.
	$args = array(
		'plugin_file' => __FILE__,
	);

	$plugin = Genesis_Archive_Titles::get_instance( $args );
	$plugin->run();

}
run_genesis_archive_titles();
