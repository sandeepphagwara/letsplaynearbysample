<?php

// Shortcode to display the message form
function member_send_message_form($atts) {
    ob_start();

    // Get the ID of the user to whom the message will be sent
    $recipient_id = isset($_GET['to_user']) ? intval($_GET['to_user']) : 0;
    $current_user_id = get_current_user_id();

    // If no recipient, show an error
    if (!$recipient_id) {
        return '<p>No recipient specified. Please try again.</p>';
    }

    // Check if the user is trying to send a message
    if (isset($_POST['send_message']) && !empty($_POST['message_content'])) {
        $message_content = sanitize_textarea_field($_POST['message_content']);
        if (!empty($message_content)) {
            // Save the message in the database
            $message_data = array(
                'post_title'   => 'Message from ' . get_userdata($current_user_id)->user_login,
                'post_content' => $message_content,
                'post_status'  => 'publish',
                'post_type'    => 'private_message',
                'post_author'  => $current_user_id, // Message sender
                'meta_input'   => array(
                    'recipient_id' => $recipient_id, // Store recipient ID
                ),
            );
            wp_insert_post($message_data); // Insert the message as a post

            echo '<p>Your message has been sent!</p>';
        } else {
            echo '<p>Please enter a message.</p>';
        }
    }

    // Message form
    ?>
    <form action="" method="POST">
        <h3>Send Message to <?php echo esc_html(get_userdata($recipient_id)->user_login); ?></h3>
        <p>
            <label for="message_content">Your Message:</label><br>
            <textarea name="message_content" id="message_content" rows="4" cols="50" required></textarea>
        </p>
        <p>
            <input type="submit" name="send_message" value="Send Message">
        </p>
    </form>
    <?php

    return ob_get_clean();
}
add_shortcode('send_message_form', 'member_send_message_form');

// Register the custom post type for private messages
function register_private_message_post_type() {
    $args = array(
        'public'       => false,
        'label'        => 'Private Messages',
        'supports'     => array('title', 'editor'),
        'show_in_menu' => false, // Don't show it in the admin menu
        'has_archive'  => false,
    );
    register_post_type('private_message', $args);
}
add_action('init', 'register_private_message_post_type');


// Shortcode to display user's inbox (received messages)
function member_inbox() {
    ob_start();
    $current_user_id = get_current_user_id();

    // Query to get all messages where the current user is the recipient
    $args = array(
        'post_type'   => 'private_message',
        'post_status' => 'publish',
        'meta_key'    => 'recipient_id',
        'meta_value'  => $current_user_id,
        'posts_per_page' => -1, // Get all received messages
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<h3>Your Inbox</h3>';
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $sender_id = get_post_field('post_author', get_the_ID()); // Get sender's ID
            $sender_name = get_userdata($sender_id)->user_login;
            ?>
            <li>
                <strong>From: <?php echo esc_html($sender_name); ?></strong><br>
                <div><?php echo wp_kses_post(get_the_content()); ?></div>
            </li>
            <?php
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>You have no messages in your inbox.</p>';
    }

    return ob_get_clean();
}
add_shortcode('inbox', 'member_inbox');

// Shortcode to display user's sent messages
function member_sent_messages() {
    ob_start();
    $current_user_id = get_current_user_id();

    // Query to get all messages sent by the current user
    $args = array(
        'post_type'   => 'private_message',
        'post_status' => 'publish',
        'post_author' => $current_user_id,
        'posts_per_page' => -1, // Get all sent messages
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<h3>Your Sent Messages</h3>';
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $recipient_id = get_post_meta(get_the_ID(), 'recipient_id', true);
            $recipient_name = get_userdata($recipient_id)->user_login;
            ?>
            <li>
                <strong>To: <?php echo esc_html($recipient_name); ?></strong><br>
                <div><?php echo wp_kses_post(get_the_content()); ?></div>
            </li>
            <?php
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>You have no sent messages.</p>';
    }

    return ob_get_clean();
}
add_shortcode('sent_messages', 'member_sent_messages');

