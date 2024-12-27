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
