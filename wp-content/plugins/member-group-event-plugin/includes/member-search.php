<?php


require_once( plugin_dir_path( __FILE__ ) . 'function.php');

// Shortcode for displaying the Member search form
function display_member_search_form() {
    ob_start();
    ?>
    <div class="member-search-container">
        <h3>Search</h3>
        <form method="GET" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="form-group-full form-radio">
                <label for="sports">Select sports</label>
                <?php echo generate_sports_checkbox1( 'user_sports', [], 'Choose your favorite sport', array( 'required' => 'required' ), 'Search' );?>
            </div>
            <div class="member-search-columns">
                <label for="city">City:</label>
                <input type="text" name="city" required />
                </div>
            <div class="member-search-columns">
                <label for="state">State:</label>
                <input type="text" name="state" required />
                </div>
            <div class="member-search-button">
                <input type="submit" name="submit_searh" value="Search"/>
                </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('member_search_form', 'display_member_search_form');

// Function to search for users by name
function search_for_members($sport, $city, $state) {
    global $wpdb;

    // Setup arguments for WP_User_Query
    $args = array(
        'meta_query' => array(
            'relation' => 'AND', // All conditions must match

            // City meta query
            array(
                'key'     => 'city', // Custom usermeta field for city
                'value'   => $city,
                'compare' => 'LIKE', // Can be LIKE for partial match
            ),
            
            // State meta query
            array(
                'key'     => 'state', // Custom usermeta field for state
                'value'   => $state,
                'compare' => 'LIKE', // Can be LIKE for partial match
            ),
            
            // Sports meta query
            array(
                'key'     => 'user_sports', // Custom usermeta field for sports
                'value'   => $sport,
                'compare' => 'LIKE', // Can be LIKE for partial match
            ),
        ),
        'fields' => 'all',
    );

    // Run the query
    $user_query = new WP_User_Query($args);

    if (!empty($user_query->results)) {
       
    ?> 
    <div class="member-search-container">
    <h3><?php echo esc_html($sport); ?> Players</h3>
    <div class="member-grid">
    <?php
        foreach ($user_query->results as $user) {
            ?>
            <div class="member-card">
                <?php
                    $profile_image = get_user_meta($user->ID, 'profile_image', true);

                    // Display the image if it's set
                    if ($profile_image) {
                        echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" style="max-width: 200px; height: auto;" />';
                    } else {
                        // Fallback image if not set
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-profile.jpg') . '" alt="Profile Image" style="max-width: 2000px; height: auto;" />';
                    }
                ?>
                <div class="member-info">
                    <h3 class="nickname"><?php echo $user->user_login ?> </h3>
                    <p class="age-gender"><?php echo get_user_meta($user->ID, 'user_age', true) ?>, Male</p>
                    <p class="description"><?php echo get_user_meta($user->ID, 'user_about_me', true) ?>.</p>
                </div>
            </div><?php
        }
        ?></div><?php
        
    } else {
        echo 'No users found based on your criteria.';
    }
    ?> </div><?php
    
}

// Shortcode for displaying search results
function display_member_search_results() {
    global $wpdb;
    ob_start();
    if (isset($_GET['submit_searh'])) {
    
        // Get the search parameters (you can adjust this to get data from a form or URL)
        $city = isset($_GET['city']) ? sanitize_text_field($_GET['city']) : '';
        $state = isset($_GET['state']) ? sanitize_text_field($_GET['state']) : '';
        $sports = isset($_GET['user_sports']) ? array_map( 'sanitize_text_field', $_GET['user_sports'] ) : [];

        $len = count($sports);

        for ($i = 0; $i <$len; $i++) {
            $results[$sports[$i]] = search_for_members($sports[$i], $city, $state);
          }
    }
    return ob_get_clean();
}

add_shortcode('member_search_results', 'display_member_search_results');

add_action('pre_user_query', function($query) {
    // Check if the 'state' field is being modified here
    // You can log or print the query object to debug
    error_log('Redirecting to: ' .print_r($query, true)); // Log the query for debugging
});
