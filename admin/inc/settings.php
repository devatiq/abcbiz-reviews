<?php
namespace ABCBizRev\Admin\Inc\Settings;

defined('ABSPATH') or die('This is not the place you deserve!');

class ABCBizRev_Settings {
    public function __construct() {
        add_action('admin_menu', array($this, 'abcbizrev_add_admin_menu'));
        add_action('admin_init', array($this, 'abcbizrev_settings_init'));
    }

    public function abcbizrev_add_admin_menu() {
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
            <form action="options.php" method="post">
                <?php
                settings_errors();
                settings_fields('abcbizrev_reviews');
                do_settings_sections('abcbizrev_reviews');
                submit_button();
                ?>
            </form>          
        </div>
        <?php
    }

    public function abcbizrev_settings_init() {
        register_setting('abcbizrev_reviews', 'abcbizrev_redirect_url', ['sanitize_callback' => 'esc_url_raw']);
        register_setting('abcbizrev_reviews', 'abcbizrev_review_status', ['sanitize_callback' => 'sanitize_text_field']);


        add_settings_section(
            'abcbizrev_reviews_main_section', 
            __('Main Settings', 'abcbiz-reviews'), 
            array($this, 'abcbizrev_reviews_main_section_cb'), 
            'abcbizrev_reviews'
        );
        //redirect url
        add_settings_field(
            'abcbizrev_redirect_url',
            __('Redirect URL', 'abcbiz-reviews'),
            array($this, 'abcbizrev_redirect_url_field_cb'),
            'abcbizrev_reviews',
            'abcbizrev_reviews_main_section'
        );

        // post status
        add_settings_field(
            'abcbizrev_review_status', // ID
            __('Default Review Status', 'abcbiz-reviews'), // Title
            array($this, 'abcbizrev_review_status_field_cb'), // Callback function
            'abcbizrev_reviews', // Page
            'abcbizrev_reviews_main_section' // Section           
        );
    }

    public function abcbizrev_reviews_main_section_cb() {
        echo '<p>' . esc_html__('Set your preferences for the ABCBiz Reviews plugin.', 'abcbiz-reviews') . '</p>';
    }

    public function abcbizrev_redirect_url_field_cb() {
        $redirect_url = get_option('abcbizrev_redirect_url');
        echo '<input type="text" id="abcbizrev_redirect_url" class="regular-text" name="abcbizrev_redirect_url" value="' . esc_attr($redirect_url) . '" />';
    }  

    public function abcbizrev_review_status_field_cb() {
        $post_status = get_option('abcbizrev_review_status', 'pending'); // Default to 'pending' if not set
        ?>
        <select id="abcbizrev_review_status" name="abcbizrev_review_status">
            <option value="publish" <?php selected($post_status, 'publish'); ?>><?php echo esc_html__('Publish', 'abcbiz-reviews'); ?></option>
            <option value="pending" <?php selected($post_status, 'pending'); ?>><?php echo esc_html__('Pending', 'abcbiz-reviews'); ?></option>
            <option value="draft" <?php selected($post_status, 'draft'); ?>><?php echo esc_html__('Draft', 'abcbiz-reviews'); ?></option>
        </select>
        <?php
    }
    
}