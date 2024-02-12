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
                wp_nonce_field('abcbizrev_reviews_setting_fields_action', 'abcbizrev_reviews_settings_nonce');
                submit_button();
                ?>
            </form>          
        </div>
        <?php
    }

    public function abcbizrev_settings_init() {
        // Register each setting individually if saving them as separate options
        register_setting('abcbizrev_reviews', 'abcbizrev_redirect_url', array($this, 'validate_input'));

        add_settings_section(
            'abcbizrev_reviews_main_section', 
            __('Main Settings', 'abcbiz-reviews'), 
            array($this, 'abcbizrev_reviews_main_section_cb'), 
            'abcbizrev_reviews'
        );

        add_settings_field(
            'abcbizrev_redirect_url',
            __('Redirect URL', 'abcbiz-reviews'),
            array($this, 'abcbizrev_redirect_url_field_cb'),
            'abcbizrev_reviews',
            'abcbizrev_reviews_main_section'
        );
    }

    public function abcbizrev_reviews_main_section_cb() {
        echo '<p>' . __('Set your preferences for the ABCBiz Reviews plugin.', 'abcbiz-reviews') . '</p>';
    }

    public function abcbizrev_redirect_url_field_cb() {
        $redirect_url = get_option('abcbizrev_redirect_url');
        echo '<input type="text" id="abcbizrev_redirect_url" class="regular-text" name="abcbizrev_redirect_url" value="' . esc_attr($redirect_url) . '" />';
    }

    public function validate_input($input) {
        //nonce verification for security
        check_admin_referer('abcbizrev_reviews_setting_fields_action', 'abcbizrev_reviews_settings_nonce');

        // Validate and sanitize the redirect URL
        $sanitized_input = esc_url_raw($input);
        return $sanitized_input;
    }
}