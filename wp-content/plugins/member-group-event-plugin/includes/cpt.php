<?php

// Register Group Custom Post Type
function create_group_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Groups',
            'singular_name' => 'Group',
            'add_new_item' => 'Add New Group',
            'edit_item' => 'Edit Group',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true, // For Gutenberg
        'supports' => array( 'title', 'editor', 'author' ),
        'rewrite' => array('slug' => 'groups'),
        'show_in_menu' => true,
    );
    register_post_type('group', $args);
}
add_action('init', 'create_group_cpt');

// Register Event Custom Post Type
function create_event_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true, // For Gutenberg
        'supports' => array( 'title', 'editor', 'author', 'date' ),
        'rewrite' => array('slug' => 'events'),
        'show_in_menu' => true,
    );
    register_post_type('event', $args);
}
add_action('init', 'create_event_cpt');
