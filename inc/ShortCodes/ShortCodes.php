<?php
namespace ABCBizRev\Inc\ShortCodes;

defined('ABSPATH') or die('This is not the place you deserve!');

// Import the GridReview class
use ABCBizRev\Inc\FrontEnd\Templates\GridReview\GridReview;
use ABCBizRev\Inc\FeedbackForm\FeedbackFormHandler;

class ReviewShortcode {
    public function __construct() {

        add_shortcode('abcbizrev_feedback_form', [$this, 'display_feedback_form']); // Display feedback form
        add_shortcode('abcbizrev_reviews', [$this, 'display_grid_review']); // Display grid review
      
    }
    
    //display feedback form
    public function display_feedback_form($atts) {
        $feedbackFormHandler = new FeedbackFormHandler();
        return $feedbackFormHandler->display_feedback_form($atts);
    }

    //display grid review
    public function display_grid_review($atts) {
        // Delegate the display logic to the GridReview class
        return GridReview::display_grid_review_markup($atts);
    }
 
    
}

