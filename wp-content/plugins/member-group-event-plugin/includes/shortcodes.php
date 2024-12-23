<?php

require_once( plugin_dir_path( __FILE__ ) . 'function.php');

// Shortcode for displaying the Group creation form
function display_group_creation_form() {
    ob_start();
    ?>
    <form id="create-group-form" method="POST">
        <label for="group_name">Group Name:</label>
        <input type="text" name="group_name" id="group_name" required>
        <label for="group_description">Description:</label>
        <textarea name="group_description" id="group_description" required></textarea>
        <input type="submit" name="create_group" value="Create Group">
    </form>
    <?php
    if ( isset( $_POST['create_group'] ) ) {
        $group_name = sanitize_text_field( $_POST['group_name'] );
        $group_description = sanitize_textarea_field( $_POST['group_description'] );

        // Insert the Group into the database
        $group_post = array(
            'post_title' => $group_name,
            'post_content' => $group_description,
            'post_type' => 'group',
            'post_status' => 'publish',
        );
        $group_id = wp_insert_post( $group_post );
    }
    return ob_get_clean();
}
add_shortcode( 'create_group_form', 'display_group_creation_form' );

// Shortcode for displaying the Event creation form
function display_event_creation_form() {
    ob_start();
    ?>
    <form id="create-event-form" method="POST">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" id="event_name" required>
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" id="event_date" required>
        <label for="event_description">Description:</label>
        <textarea name="event_description" id="event_description" required></textarea>
        <input type="submit" name="create_event" value="Create Event">
    </form>
    <?php
    if ( isset( $_POST['create_event'] ) ) {
        $event_name = sanitize_text_field( $_POST['event_name'] );
        $event_date = sanitize_text_field( $_POST['event_date'] );
        $event_description = sanitize_textarea_field( $_POST['event_description'] );

        // Insert the Event into the database
        $event_post = array(
            'post_title' => $event_name,
            'post_content' => $event_description,
            'post_type' => 'event',
            'post_status' => 'publish',
            'meta_input' => array(
                'event_date' => $event_date,
            ),
        );
        $event_id = wp_insert_post( $event_post );
    }
    return ob_get_clean();
}
add_shortcode( 'create_event_form', 'display_event_creation_form' );


// Shortcode for displaying the Member search form
function display_member_search_form() {
    ob_start();
    ?>
    <form method="GET" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
        <label for="search_members">Search Members:</label>
        <input type="text" name="search_members" id="search_members" placeholder="Search by name...">
        <input type="submit" value="Search">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('member_search_form', 'display_member_search_form');

// Function to search for users by name
function search_for_members($search_term) {
    global $wpdb;

    // Prepare the SQL query to search for users
    $query = "
        SELECT ID, user_login, user_nicename, user_email 
        FROM $wpdb->users
        WHERE user_login LIKE %s
        OR display_name LIKE %s
    ";

    // Perform the search query
    $search_like = '%' . $wpdb->esc_like($search_term) . '%';
    $results = $wpdb->get_results($wpdb->prepare($query, $search_like, $search_like));

    return $results;
}

// Shortcode for displaying search results
function display_member_search_results() {
    if (isset($_GET['search_members'])) {
        $search_term = sanitize_text_field($_GET['search_members']);
        
        // Call the search function
        $members = search_for_members($search_term);
        
        if ($members) {
            ob_start();
            ?>
            <h2>Search Results</h2>
            <ul>
                <?php foreach ($members as $member): ?>
                    <li>
                        <strong><?php echo esc_html($member->user_nicename); ?></strong> 
                        (<?php echo esc_html($member->user_email); ?>)
                        <br>
                        <a href="<?php echo get_author_posts_url($member->ID); ?>">View Profile</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            return ob_get_clean();
        } else {
            return '<p>No members found.</p>';
        }
    }
    return ''; // Return nothing if no search term is provided
}
add_shortcode('member_search_results', 'display_member_search_results');