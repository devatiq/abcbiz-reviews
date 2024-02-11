<?php
namespace ABCBizRev\Inc\FeedbackForm;

defined('ABSPATH') or die;

class FeedbackFormHandler
{
 

    public function __construct()
    {    
        add_action('admin_post_nopriv_submit_abcbizrev_feedback', [$this, 'handle_submission']); // For non-logged-in users
        add_action('admin_post_submit_abcbizrev_feedback', [$this, 'handle_submission']); // For logged-in users
    }
     

    public function display_feedback_form($atts = [])
    {
        // Define default values for the attributes
        $defaults = [           
            'btn_text' => 'Submit Feedback', 
        ];

        // Override defaults with user-provided attributes
        $atts = shortcode_atts($defaults, $atts, 'abcbizrev_feedback_form');

        // Form HTML
        ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php wp_nonce_field('abcbizrev_feedback_nonce_action', 'abcbizrev_feedback_nonce'); ?>
            <input type="hidden" name="action" value="submit_abcbizrev_feedback">

            <p><label for="abcbizrev_name">
                    <?php _e('Name:', 'abcbiz-reviews'); ?>
                </label>
                <input type="text" id="abcbizrev_name" name="abcbizrev_name" required>
            </p>

            <p><label for="abcbizrev_email">
                    <?php _e('Email:', 'abcbiz-reviews'); ?>
                </label>
                <input type="email" id="abcbizrev_email" name="abcbizrev_email" required>
            </p>

            <p><label for="abcbizrev_subject">
                    <?php _e('Subject:', 'abcbiz-reviews'); ?>
                </label>
                <input type="text" id="abcbizrev_subject" name="abcbizrev_subject" required>
            </p>

            <p><label for="abcbizrev_comments">
                    <?php _e('Comments:', 'abcbiz-reviews'); ?>
                </label>
                <textarea id="abcbizrev_comments" name="abcbizrev_comments" required></textarea>
            </p>

            <p><label for="abcbizrev_rating">
                    <?php _e('Rating:', 'abcbiz-reviews'); ?>
                </label>
                <select id="abcbizrev_rating" name="abcbizrev_rating" required>
                    <option value="">
                        <?php _e('Select a rating', 'abcbiz-reviews'); ?>
                    </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5" selected>5</option>
                </select>
            </p>

            <input type="submit" value="<?php echo esc_attr($atts['btn_text']); ?>">
        </form>
        <?php
    }

    public function handle_submission()
    {
        // Check nonce for security
        if (!isset($_POST['abcbizrev_feedback_nonce']) || !wp_verify_nonce(sanitize_text_field( wp_unslash ($_POST['abcbizrev_feedback_nonce'])), 'abcbizrev_feedback_nonce_action')) {
            wp_die('Security check failed');
        }

        // Server-side validation for required fields
        $required_fields = ['abcbizrev_name', 'abcbizrev_email', 'abcbizrev_subject', 'abcbizrev_comments', 'abcbizrev_rating'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                wp_die('Please fill all required fields.');
            }
        } 

        // Enhanced email validation
        if (!is_email($_POST['abcbizrev_email'])) {
            wp_die(__('Please enter a valid email address.', 'abcbiz-reviews'));
        }

        // Sanitize and prepare post data
        $post_data = [
            'post_title' => sanitize_text_field($_POST['abcbizrev_subject']),
            'post_content' => sanitize_textarea_field($_POST['abcbizrev_comments']),
            'post_status' => 'pending',
            'post_type' => 'abcbizrev_reviews',
            'meta_input' => [
                'abcbizrev_review_name' => sanitize_text_field($_POST['abcbizrev_name']),
                'abcbizrev_review_email' => sanitize_email($_POST['abcbizrev_email']),
                'abcbizrev_review_rating' => intval($_POST['abcbizrev_rating']),
            ],
        ];

        // Insert the post
        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            // Redirect to a thank you page or display a success message
            wp_redirect(home_url('/'));
            exit;
        } else {
            wp_die('An error occurred while submitting your feedback.');
        }
    }
}