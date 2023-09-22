<?php
/**
 * Wellness Wag Plugin
 *
 * @package   Wellness Wag
 * @link      https://rankfoundry.com
 * @copyright Copyright (C) 2021-2023, Rank Foundry LLC - support@rankfoundry.com
 * @since     1.0.0
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Wellness Wag
 * Plugin URI:  https://rankfoundry.com/plugins/seo
 * Description: A plugin of custom features for use by Wellness Wag.
 * Version:     1.0.1
 * Author:      Rank Foundry
 * Author URI:  https://rankfoundry.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wellness-wag
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin version
if (!defined('WELLNESS_WAG_VERSION')) {
    define('WELLNESS_WAG_VERSION', '1.0.1');
}

// Define plugin directory path
if (!defined('WELLNESS_WAG_PLUGIN_DIR')) {
    define('WELLNESS_WAG_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Define plugin file
if ( ! defined( 'WELLNESS_WAG_FILE' ) ) {
    define( 'WELLNESS_WAG_FILE', __FILE__ );
}

// Load the Composer autoloader.
require_once WELLNESS_WAG_PLUGIN_DIR . 'vendor/autoload.php';

// Include the main class file
require_once WELLNESS_WAG_PLUGIN_DIR . 'includes/class-wellness-wag.php';


// Begin execution of the plugin.
function run_wellness_wag() {
    $plugin = new Wellness_Wag();
    $plugin->run();
}

run_wellness_wag();      
