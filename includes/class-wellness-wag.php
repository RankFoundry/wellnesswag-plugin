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

    private $admin;
    private $states;

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
        require_once WELLNESS_WAG_PLUGIN_DIR . 'includes/class-wellness-wag-states.php';
        require_once WELLNESS_WAG_PLUGIN_DIR . 'public/class-wellness-wag-shortcode.php';
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
        );

        //Set the branch that contains the stable release.
        $pluginUpdateChecker->setBranch('main');

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

        $this->states = new WellnessWag_States($this->plugin_name, $this->version);
        register_setting($this->plugin_name, 'wellnesswag_states', array($this, 'sanitize_urls'));

        // Add AJAX handler for the sync
        add_action('wp_ajax_reset_states', array($this->admin, 'reset_states'));
        add_action('wp_ajax_fetch_states', array($this->admin, 'fetch_states'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     */
    private function define_public_hooks() {
        $shortcode = new WellnessWag_Shortcode($this->plugin_name, $this->version);
        add_shortcode('wellnesswag-state-dropdown', array($shortcode, 'state_dropdown'));
    }

    /**
     * Actions to perform on plugin activation.
     */
    public function activate() {
        $states = new WellnessWag_States($this->plugin_name, $this->version);
        $states->register_default_urls();
    }

    /**
     * Actions to perform on plugin deactivation.
     */
    public function deactivate() {
        $states = new WellnessWag_States($this->plugin_name, $this->version);
        $states->remove_urls();
    }

    /**
     * Run the plugin.
     */
    public function run() {
        // Any code that needs to execute upon plugin initialization would go here.
    }

}

