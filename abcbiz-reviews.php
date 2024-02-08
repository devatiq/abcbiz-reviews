<?php
/**
 * Plugin Name: ABCBiz Reviews
 * Plugin URI: https://github.com/devatiq/abcbiz-reviews
 * Description: A plugin for adding and displaying business reviews and feedback.
 * Version: 1.0
 * Author: SupreoX Limited
 * Author URI: https://supreox.com
 * Text Domain: abcbiz-reviews
 * Domain Path: /languages
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/devatiq/abcbiz-reviews
 * Prefix: abcbizrev
 */


// If this file is called directly, abort!!!
defined('ABSPATH') or die('This is not the place you deserve!');


// Define Plugin Version
define('ABCBIZREV_VERSION', '1.0');

// Define Paths
define('ABCBIZREV_PATH', plugin_dir_path(__FILE__));
define('ABCBIZREV_URL', plugin_dir_url(__FILE__));
define('ABCBIZREV_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/');
define('ABCBIZREV_ADMIN_ASSETS_URL', plugin_dir_url(__FILE__) . 'admin/assets/');

class ABCBiz_Reviews
{
    protected static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
             
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles_scripts'));

        $this->ABCBizReviews_include_files(); //include extranal files
        $this->initializeComponents(); // Initialize Components class  
    }

    public function load_textdomain() {
        load_plugin_textdomain('abcbiz-reviews', false, ABCBIZREV_PATH . 'languages/');
    }
    
    //include extranal files
    public function ABCBizReviews_include_files() {
        require_once ABCBIZREV_PATH . 'admin/inc/settings.php';
    }

    private function initializeComponents() {
        if (class_exists('\ABCBizRev\Admin\Inc\Settings\ABCBizRev_Settings')) {
            new \ABCBizRev\Admin\Inc\Settings\ABCBizRev_Settings();
        }
    }
    public function enqueue_public_styles_scripts()
    {
        wp_enqueue_style('abcbizrev-frontend-style', ABCBIZREV_ASSETS_URL . 'css/style.css', array(), ABCBIZREV_VERSION);
        wp_enqueue_script('abcbizrev-frontend-script', ABCBIZREV_ASSETS_URL . 'js/main.js', array('jquery'), ABCBIZREV_VERSION, true);
    }

    public function enqueue_admin_styles_scripts($hook)
    {
        wp_enqueue_style('abcbizrev-admin-style', ABCBIZREV_ADMIN_ASSETS_URL . 'css/style.css', array(), ABCBIZREV_VERSION);
        wp_enqueue_script('abcbizrev-admin-script', ABCBIZREV_ADMIN_ASSETS_URL . 'js/main.js', array('jquery'), ABCBIZREV_VERSION, true);
    }

}
// Automatically initialize the plugin.
ABCBiz_Reviews::get_instance();