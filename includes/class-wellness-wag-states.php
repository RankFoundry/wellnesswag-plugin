<?php

/**
 * Wellness Wag States Class
 */

 if (!defined('WPINC')) {
    die;
}

class WellnessWag_States {

    // The unique identifier of this plugin.
    private $plugin_name;

    // The current version of the plugin.
    private $version;

    // define states option name
    private $states_option_name = 'wellnesswag_states';

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    // Register default state URLs
    public function register_default_urls() {
        if (false === get_option($this->states_option_name)) {
            update_option($this->states_option_name, json_encode($this->default_state_urls()));
        }
    }

    // Remove urls
    public function remove_urls() {
        delete_option($this->states_option_name);
    }

    // Get all state URLs
    public function get_state_urls() {
        $state_data = get_option($this->states_option_name);
        if (false === $state_data) {
            return []; // Return an empty array if the option does not exist
        }
        return is_array($state_data) ? $state_data : json_decode($state_data, true);
    }

    // Update state URLs
    public function update_state_urls($new_urls) {
        update_option($this->states_option_name, json_encode($new_urls));
    }

    public function sanitize_urls($input) {
        // Ensure input is an array
        if (!is_array($input)) {
            return array();
        }
    
        // Sanitize each URL
        foreach ($input as $state => $url) {
            $input[$state] = esc_url_raw($url);
        }
    
        // Save to the database
        $this->update_state_urls($input);
    
        return $input;
    }

    // Define default state URLs
    private function default_state_urls() {
        $states = [
            'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 
            'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 
            'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 
            'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 
            'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 
            'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 
            'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 
            'Washington, D.C.', 'West Virginia', 'Wisconsin', 'Wyoming'
        ];
        $default_urls = [];
        foreach ($states as $state) {
            $default_urls[$state] = "https://wellnesswag.com/esa-letter";
        }
        return $default_urls;
    }

}