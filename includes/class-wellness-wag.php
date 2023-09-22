<?php

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * RankFoundry SEO Main Class
 */

if (!defined('WPINC')) {
    die;
}

class Wellness_Wag {

    /**
     * The unique identifier of this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        if (defined('WELLNESS_WAG_VERSION')) {
            $this->version = WELLNESS_WAG_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wellness-wag';

        $this->load_dependencies();
        $this->set_locale();
        $this->initialize_update_checker();
        $this->define_public_hooks();

        if (is_admin()) {
            $this->define_admin_hooks();
        }
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {

    }

    /**
     * Define the locale for this plugin for internationalization.
     */
    private function set_locale() {
        // This is where you'd set up any translation/internationalization functionality.
    }

    /**
     * Load the update checker
     */
    private function initialize_update_checker() {
        $pluginUpdateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/rankfoundry/wellnesswag-plugin/',
            WELLNESS_WAG_FILE,
            'wellness-wag',
            48
        );

        //Set the branch that contains the stable release.
        $pluginUpdateChecker->setBranch('master');

        //Optional: If you're using a private repository, specify the access token like this:
        //$myUpdateChecker->setAuthentication('your-token-here');
    }

    /**
     * Register all of the hooks related to the admin area functionality.
     */
    private function define_admin_hooks() {

        require_once WELLNESS_WAG_PLUGIN_DIR . 'admin/class-wellness-wag-admin.php';
        $this->admin = new Wellness_Wag_Admin($this->plugin_name, $this->version);

        add_action('in_admin_header', array($this->admin, 'wellness_wag_remove_other_notices'), 1000); // The high priority ensures it runs after other plugins.
        add_action('admin_enqueue_scripts', array($this->admin, 'enqueue_styles'));
        add_action('admin_menu', array($this->admin, 'add_menu'));
        add_action('admin_init', array($this->admin, 'register_settings'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     */
    private function define_public_hooks() {
        // This will involve enqueueing scripts/styles for the frontend, and other related functions.
    }

    /**
     * Run the plugin.
     */
    public function run() {
        // Any code that needs to execute upon plugin initialization would go here.
    }

}

