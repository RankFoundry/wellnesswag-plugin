<?php

class Wellness_Wag_Admin {

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
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    public const option_group = "wellnesswag_group";
    public const option_key = "wellnesswag_options";
    public const page_slug = "wellness-wag";
    public const page_title = "Wellness Wag Settings";
    public const menu_title = "Wellness Wag";
    
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    // Register settings page under WP Settings
    public function add_menu() {
        $menu_icon = file_get_contents(WELLNESS_WAG_PLUGIN_DIR . 'assets/images/wellness-wag-icon.svg');

        add_menu_page(
            $this::page_title,
            $this::menu_title,
            'manage_options',
            $this::page_slug,
            array($this, 'display_dashboard_page'),
            'data:image/svg+xml;base64,' . base64_encode( $menu_icon ),
            4
        );

        add_submenu_page($this::page_slug, 'Dashboard', 'Dashboard', 'manage_options', $this::page_slug, array($this, 'display_dashboard_page'));
    }

    // Display the general page
    public function display_dashboard_page() {
        include_once 'partials/admin-dashboard.php';
    }
    
    
    // Register settings
    public function register_settings() {
        
    }

    public function enqueue_styles() {
        // Only enqueue on your plugin's pages
        if ($this->is_wellness_wag_page()) {
            wp_enqueue_style('wellness-wag-tailwind', plugin_dir_url(__DIR__) . 'assets/css/tailwind.css', array(), WELLNESS_WAG_VERSION);
            wp_enqueue_script('alpine', 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', array(), null, true);
        }
    }

    /**
     * Check if the page is one of ours.
     *
     * @since 1.1.10
     *
     * @return bool
     */
    public function is_wellness_wag_page() {
        if ( ! is_admin() && ( ! isset($_REQUEST['page']) || ! isset($_REQUEST['post_type']))) {
            return false;
        }

        if (isset($_REQUEST['page'])) {
            return 0 === strpos($_REQUEST['page'], $this::page_slug);
        } elseif (isset($_REQUEST['post_type'])) {
            if (is_array($_REQUEST['post_type']) && !empty($_REQUEST['post_type'])) {
                return 0 === strpos($_REQUEST['post_type'][0], $this::page_slug);
            } else {
                return 0 === strpos($_REQUEST['post_type'], $this::page_slug);
            }
        }
    }

    /**
     * Only add our notices on our pages.
     *
     * @since 1.1.10
     *
     * @return bool
     */
    public function wellness_wag_remove_other_notices() {
        if ($this->is_wellness_wag_page()) {
            remove_all_actions('network_admin_notices');
            remove_all_actions('admin_notices');
            remove_all_actions('user_admin_notices');
            remove_all_actions('all_admin_notices');

            // If in the future you have specific notices for your plugin, you can add them here.
            // e.g., add_action('admin_notices', 'wellness_wag_admin_notices');
        }
    }
}
