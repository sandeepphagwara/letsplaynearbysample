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

// Create Custom Post Types and Taxonomies
require_once( plugin_dir_path( __FILE__ ) . 'includes/cpt.php');

// Create Shortcodes and Front-End Functions
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php');

// Handle Members and Group Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/member-group.php');

// Handle Members and Profile Management
require_once( plugin_dir_path( __FILE__ ) . 'includes/member-profile.php');