<?php
namespace ABCBizRev\Inc\FrontEnd\Templates\GridReview;

defined('ABSPATH') or die('This is not the place you deserve!');

class GridReview {
    public static function display_grid_review_markup() {
        
        ob_start();
        // Define your custom query to fetch reviews
        $args = [
            'post_type' => 'abcbizrev_reviews',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];
        $query = new \WP_Query($args);

        // Check if the query returns any posts
        if ($query->have_posts()) {
            echo '<div class="abcbizrev-testimonial-wrapper-area"><div class="abcbizrev-testimonial-wrapper"><div class="abcbizrev-testimonial-slider abcbizrev-testimonial-grids">';
            // Loop through the posts
            while ($query->have_posts()) {
                $query->the_post();
                $testimonial_rating = get_post_meta(get_the_ID(), 'abcbizrev_review_rating', true);
                ?>
                    <div class="abcbizrev-testimonial-single-item">
                        <div class="abcbizrev-testimonial-client-info">
                            <h3><?php the_title(); ?></h3>
                        </div>
                        <div class="abcbizrev-testimonial-rating">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <i class="<?php echo ($i <= $testimonial_rating) ? 'eicon-star' : 'eicon-star-o'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="abcbizrev-testimonial-content">
                            <p><?php the_content(); ?></p>
                        </div>
                    </div>
                <?php
            }
            echo '</div></div></div>';
        }

        // Restore original Post Data
        wp_reset_postdata();

        // Return the buffered content
        return ob_get_clean();
    }
}