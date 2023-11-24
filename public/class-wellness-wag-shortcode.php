<?php

class WellnessWag_Shortcode {

    // The unique identifier of this plugin.
    private $plugin_name;

    // The current version of the plugin.
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }


    public function state_dropdown($atts){
        $wellnessWagStates = new WellnessWag_States($this->plugin_name, $this->version);
        $states = $wellnessWagStates->get_state_urls();  // Fetch the states URLs using the instance method
    
        $content = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">';
        $content .= '<option value="">Select Your State</option>';
    
        foreach ($states as $state_name => $state_url) {
            $content .= "<option value=\"{$state_url}\">{$state_name}</option>";
        }
    
        $content .= '</select>';
    
        return $content;
    }
    
}