<?php 
namespace ABCBizRev\Inc\PostTypes;

defined('ABSPATH') or die('This is not the place you deserve!');

class PostTypes {
    public function __construct() {
        add_action( 'init', array( $this, 'register_custom_post_type' ) );
    }

    public function register_custom_post_type() {
        $labels = array(
            'name'                  => _x( 'ABCBiz Reviews', 'abcbiz-reviews'),
            'singular_name'         => _x( 'Review', 'abcbiz-reviews'),
            'menu_name'             => __( 'ABCBiz Reviews', 'abcbiz-reviews'),
            'name_admin_bar'        => __( 'ABCBizRev Review', 'abcbiz-reviews'),
            'archives'              => __( 'Review Archives', 'abcbiz-reviews'),
            'attributes'            => __( 'Review Attributes', 'abcbiz-reviews'),
            'parent_item_colon'     => __( 'Parent Review:', 'abcbiz-reviews'),
            'all_items'             => __( 'All Reviews', 'abcbiz-reviews'),
            'add_new_item'          => __( 'Add New Review', 'abcbiz-reviews'),
            'add_new'               => __( 'Add New Review', 'abcbiz-reviews'),
            'new_item'              => __( 'New Review', 'abcbiz-reviews'),
            'edit_item'             => __( 'Edit Review', 'abcbiz-reviews'),
            'update_item'           => __( 'Update Review', 'abcbiz-reviews'),
            'view_item'             => __( 'View Review', 'abcbiz-reviews'),
            'view_items'            => __( 'View Reviews', 'abcbiz-reviews'),
            'search_items'          => __( 'Search Review', 'abcbiz-reviews'),
            'not_found'             => __( 'Not found', 'abcbiz-reviews'),
            'not_found_in_trash'    => __( 'Not found in Trash', 'abcbiz-reviews'),
            'featured_image'        => __( 'Image', 'abcbiz-reviews'),
            'set_featured_image'    => __( 'Set image', 'abcbiz-reviews'),
            'remove_featured_image' => __( 'Remove image', 'abcbiz-reviews'),
            'use_featured_image'    => __( 'Use as image', 'abcbiz-reviews'),
            'insert_into_item'      => __( 'Insert into review', 'abcbiz-reviews'),
            'uploaded_to_this_item' => __( 'Uploaded to this review', 'abcbiz-reviews'),
            'items_list'            => __( 'Reviews list', 'abcbiz-reviews'),
            'items_list_navigation' => __( 'Reviews list navigation', 'abcbiz-reviews'),
            'filter_items_list'     => __( 'Filter reviews list', 'abcbiz-reviews'),
        );
        $args = array(
            'label'                 => __( 'ABCBizRev Review', 'abcbiz-reviews'),
            'description'           => __( 'Post Type Description', 'abcbiz-reviews'),
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