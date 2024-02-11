<?php 
namespace ABCBizRev\Inc\CustomFields;

defined('ABSPATH') or die('This is not the place you deserve!');


class ABCBIZRevCustomFields {
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_custom_meta_boxes'));
        add_action('save_post', array($this, 'save_custom_meta_boxes'), 10, 2);
    }

    public function add_custom_meta_boxes() {
        add_meta_box(
            'abcbizrev_review_details',
            __('Review Details', 'abcbiz-reviews'),
            array($this, 'render_meta_boxes'),
            'abcbizrev_reviews',
            'normal',
            'high'
        );
    }

    public function render_meta_boxes($post) {
        // Security field for validating request
        wp_nonce_field('abcbizrev_custom_fields', 'abcbizrev_custom_fields_nonce');
    
        // Retrieve current values based on post ID
        $name = get_post_meta($post->ID, 'abcbizrev_review_name', true);
        $email = get_post_meta($post->ID, 'abcbizrev_review_email', true);
        $rating = get_post_meta($post->ID, 'abcbizrev_review_rating', true);
    
        // HTML for the form fields
        echo '<p><label for="abcbizrev_review_name">' . __('Name:', 'abcbiz-reviews') . '</label>';
        echo '<input type="text" id="abcbizrev_review_name" name="abcbizrev_review_name" value="' . esc_attr($name) . '" class="widefat" /></p>';
    
        echo '<p><label for="abcbizrev_review_email">' . __('Email:', 'abcbiz-reviews') . '</label>';
        echo '<input type="email" id="abcbizrev_review_email" name="abcbizrev_review_email" value="' . esc_attr($email) . '" class="widefat" /></p>';
    
        // Dropdown for the rating
        echo '<p><label for="abcbizrev_review_rating">' . __('Rating:', 'abcbiz-reviews') . '</label>';
        echo '<select id="abcbizrev_review_rating" name="abcbizrev_review_rating" class="widefat">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . '</option>';
        }
        echo '</select></p>';
    }
    
    public function save_custom_meta_boxes($post_id, $post) {
        // Verify the nonce before proceeding.
        if (!isset($_POST['abcbizrev_custom_fields_nonce']) || !wp_verify_nonce(sanitize_text_field( wp_unslash ($_POST['abcbizrev_custom_fields_nonce'])), 'abcbizrev_custom_fields')) {
            return $post_id;
        }

        // Skip autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // Update the meta field in the database.
        update_post_meta($post_id, 'abcbizrev_review_name', sanitize_text_field($_POST['abcbizrev_review_name']));
        update_post_meta($post_id, 'abcbizrev_review_email', sanitize_email($_POST['abcbizrev_review_email']));
        update_post_meta($post_id, 'abcbizrev_review_rating', intval($_POST['abcbizrev_review_rating']));
    }
}