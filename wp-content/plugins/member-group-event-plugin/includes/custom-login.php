<?php
/*
Plugin Name: Custom Login Plugin
Plugin URI:  https://yourwebsite.com
Description: A simple login plugin that displays the login form on the menu for users who are not logged in.
Version:     1.0
Author:      Your Name
Author URI:  https://yourwebsite.com
License:     GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


// Start output buffering to capture any unwanted output
ob_start();

// Shortcode to display the login form
function custom_login_form_shortcode() {
    // If the user is logged in, return nothing or a custom message
    // if (is_user_logged_in()) {
       // return '<p>You are already logged in.</p>';
    // }
    $error = false;
    // Handle the login form submission
    if (isset($_POST['submit_login'])) {
        // Sanitize and get the login details
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);
        
        // Attempt to authenticate the user
        $user = wp_authenticate($username, $password);

        if (is_wp_error($user)) {
            // Return the error message if login fails
            $error =  true;
        } else {
            // Set the user and log them in
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);

            // Redirect to the profile page (or your desired page) after successful login
            wp_redirect(home_url('/members'));  // Ensure you change '/profile' to your actual profile URL
            exit;  // Stop further code execution to prevent header issues
        }
    }

    // Form HTML
    ob_start();
    ?><div class="login-container">
        <div class="login-left-sidebar">
            <h2>Login</h2>
            <?php 
                if($error){
                    echo '<p class="error">Invalid username or password.</p>';
                }
            ?>
            <form action="" method="POST">
                <p>
                    <label for="username">Username:</label>
                    <input type="text" name="username" required />
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required />
                </p>
                <p>
                    <input type="submit" name="submit_login" value="Login" class="login-button" />
                </p>
            </form>
            <h5>Don't have an account? <a href="<?php echo esc_url(home_url('/register')); ?>">Register here</a></h5>
            <h5><a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a></h5>
        </div>
        <div class="login-right-sidebar">
            <h2> Get Started </h2>
            <h2> Register </h2>
            <h2> Login </h2>
            <h2> Search for members or Group or Event and Join </h2>
            <h2> Create your own Group or Event and invite others to join to play your Favorite sports  </h2>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_login_form', 'custom_login_form_shortcode');

// Add Login to the WordPress menu for non-logged-in users
function add_login_to_menu($items, $args) {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        // Add the login page to the menu for non-logged-in users
        $login_page_url = home_url('/login'); // You can change this to any page URL
        $login_link = '<li><a href="' . esc_url($login_page_url) . '"><strong style="font-size:14px">Login</strong></a></li>';
        
        // Append the Login link to the menu
        $items .= $login_link;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_login_to_menu', 10, 2);


// Register a custom login page
function register_login_page() {
    // Create the login page if it doesn't exist already
    $login_page = get_page_by_path('login');
    if (!$login_page) {
        // Create a new page for login
        $login_page_id = wp_insert_post(array(
            'post_title'   => 'Login',
            'post_content' => '[custom_login_form]',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'login',  // The slug used in the URL
        ));
    }
}
add_action('init', 'register_login_page');


// Hook to modify the menu items

function add_logout_to_menu($items, $args) {
    // Check if the user is logged in
    if (is_user_logged_in()) {
        // Add the logout link to the menu for logged-in users
        $logout_link = '<li><a href="' . wp_logout_url(home_url()) . '"><strong style="font-size:14px">Logout</strong></a></li>';
        
        // Append the Logout link to the menu
        $items .= $logout_link;
    }
    return $items;
}

// Apply the filter to the main menu
add_filter('wp_nav_menu_items', 'add_logout_to_menu', 10, 2);


// Check for output before redirecting (for debugging)
// This code is only for bebugging
function check_for_output() {
    $output = ob_get_clean();  // Get and clean the output buffer
    if (!empty($output)) {
        error_log("Output before redirect: " . $output);  // Log any unexpected output to debug.log
    }
}
// add_action('wp_footer', 'check_for_output');  // Run the check at the footer to capture output
