<?php
/**
 * Plugin Name: Member, Profile, Group & Event Manager
 * Description: A plugin to manage members, groups, and events. Users can create groups, add members, and create events.
 * Version:     1.0
 * Author:      Sandeep Baagla
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
function my_custom_plugin_enqueue_styles() {
    // Enqueue Font Awesome from CDN
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3', 'all' );
}*/

function my_plugin_enqueue_styles() {
    wp_enqueue_style('my-plugin-styles', plugin_dir_url(__FILE__) . '/assets/styles.css');
    wp_enqueue_style('my-plugin-font-awesome', plugin_dir_url(__FILE__) . '/assets/font-awesome.css');
}
// Hook into WordPress to enqueue styles
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_styles' );



// Create Custom Post Types and Taxonomies
require_once( plugin_dir_path( __FILE__ ) . 'includes/cpt.php');

// Create Shortcodes and Front-End Functions
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php');

// Handle Members and Group Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/member-group.php');

// Handle Members and Profile Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/member-profile.php');

// Members Search Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/member-search.php');

// Login Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/custom-login.php');

// Member Register Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/custom-register.php');

// Mockup's Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/sample2.php');

// Mockup's Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/sample3.php');