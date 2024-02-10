<?php
namespace ABCBizRev\Admin\Inc\Settings;

defined('ABSPATH') or die('This is not the place you deserve!');

class ABCBizRev_Settings {
    public function __construct() {
        add_action('admin_menu', array($this, 'abcbizrev_add_admin_menu'));
        add_action('admin_init', array($this, 'abcbizrev_settings_init'));
    }

    public function abcbizrev_add_admin_menu() {
        // Home Submenu under the custom post type
        add_submenu_page(
            'edit.php?post_type=abcbizrev_reviews', 
            __('Home', 'abcbiz-reviews'),
            __('Home', 'abcbiz-reviews'),
            'manage_options',
            'abcbizrev_reviews_home',
            array($this, 'abcbizrev_create_home_page')
        );
    
        // Style Submenu under the custom post type
        add_submenu_page(
            'edit.php?post_type=abcbizrev_reviews', 
            __('Style', 'abcbiz-reviews'),
            __('Style', 'abcbiz-reviews'),
            'manage_options',
            'abcbizrev_reviews_style',
            array($this, 'abcbizrev_create_style_page')
        );
        // Settings Submenu under the custom post type
        add_submenu_page(
            'edit.php?post_type=abcbizrev_reviews', 
            __('ABCBiz Reviews Settings', 'abcbiz-reviews'), 
            __('Settings', 'abcbiz-reviews'), 
            'manage_options', 
            'abcbizrev_reviews_settings', 
            array($this, 'abcbizrev_create_settings_page')
        );
            
    }
    

    public function abcbizrev_create_settings_page() {
        ?>
        <div class="wrap abcbizrev_admin_wrap">
            <h2><?php echo esc_html(get_admin_page_title()); ?></h2>            
        </div>
        <?php
    }

    public function abcbizrev_create_home_page() {
        ?>
        <div class="wrap">
            <h2><?php _e('Home', 'abcbiz-reviews'); ?></h2>
            <p><?php _e('Welcome to the Home page of ABCBiz Reviews Settings.', 'abcbiz-reviews'); ?></p>
        </div>
        <?php
    }

    public function abcbizrev_create_style_page() {
        ?>
        <div class="wrap">
            <h2><?php _e('Style', 'abcbiz-reviews'); ?></h2>
            <p><?php _e('Customize the appearance of ABCBiz Reviews.', 'abcbiz-reviews'); ?></p>
        </div>
        <?php
    }

    public function abcbizrev_settings_init() {
        // Register a settings group and a settings field for storing your settings
        register_setting('abcbizrev_reviews', 'abcbizrev_reviews_style');
    
        // Add a settings section within the page
        add_settings_section(
            'abcbizrev_reviews_main_section', // Section ID
            __('Main Settings', 'abcbiz-reviews'), // Section title
            array($this, 'abcbizrev_reviews_main_section_cb'), // Callback function for the section description
            'abcbizrev_reviews_style' // Page slug where to add this section
        );    
       
    }
    
    // Callback for the section description
        public function abcbizrev_reviews_main_section_cb() {
        echo '<p>' . __('Set your preferences for the ABCBiz Reviews plugin.', 'abcbiz-reviews') . '</p>';
    }    
    
}
