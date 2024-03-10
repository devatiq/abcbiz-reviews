<?php 
namespace ABCBizRev\Inc\PostTypes;

defined('ABSPATH') or die('This is not the place you deserve!');

class PostTypes {
    public function __construct() {
        add_action( 'init', array( $this, 'register_custom_post_type' ) );
    }

    public function register_custom_post_type() {
        $labels = array(
            'name'                  => esc_html__( 'ABCBiz Reviews', 'abcbiz-reviews'),
            'singular_name'         => esc_html__( 'Review', 'abcbiz-reviews'),
            'menu_name'             => esc_html__( 'ABCBiz Reviews', 'abcbiz-reviews'),
            'name_admin_bar'        => esc_html__( 'ABCBizRev Review', 'abcbiz-reviews'),
            'archives'              => esc_html__( 'Review Archives', 'abcbiz-reviews'),
            'attributes'            => esc_html__( 'Review Attributes', 'abcbiz-reviews'),
            'parent_item_colon'     => esc_html__( 'Parent Review:', 'abcbiz-reviews'),
            'all_items'             => esc_html__( 'All Reviews', 'abcbiz-reviews'),
            'add_new_item'          => esc_html__( 'Add New Review', 'abcbiz-reviews'),
            'add_new'               => esc_html__( 'Add New Review', 'abcbiz-reviews'),
            'new_item'              => esc_html__( 'New Review', 'abcbiz-reviews'),
            'edit_item'             => esc_html__( 'Edit Review', 'abcbiz-reviews'),
            'update_item'           => esc_html__( 'Update Review', 'abcbiz-reviews'),
            'view_item'             => esc_html__( 'View Review', 'abcbiz-reviews'),
            'view_items'            => esc_html__( 'View Reviews', 'abcbiz-reviews'),
            'search_items'          => esc_html__( 'Search Review', 'abcbiz-reviews'),
            'not_found'             => esc_html__( 'Not found', 'abcbiz-reviews'),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'abcbiz-reviews'),
            'featured_image'        => esc_html__( 'Image', 'abcbiz-reviews'),
            'set_featured_image'    => esc_html__( 'Set image', 'abcbiz-reviews'),
            'remove_featured_image' => esc_html__( 'Remove image', 'abcbiz-reviews'),
            'use_featured_image'    => esc_html__( 'Use as image', 'abcbiz-reviews'),
            'insert_into_item'      => esc_html__( 'Insert into review', 'abcbiz-reviews'),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this review', 'abcbiz-reviews'),
            'items_list'            => esc_html__( 'Reviews list', 'abcbiz-reviews'),
            'items_list_navigation' => esc_html__( 'Reviews list navigation', 'abcbiz-reviews'),
            'filter_items_list'     => esc_html__( 'Filter reviews list', 'abcbiz-reviews'),
        );
        $args = array(
            'label'                 => esc_html__( 'ABCBizRev Review', 'abcbiz-reviews'),
            'description'           => esc_html__( 'Post Type Description', 'abcbiz-reviews'),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'abcbizrev_reviews', $args );
    }
}