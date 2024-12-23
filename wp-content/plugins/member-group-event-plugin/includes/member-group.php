<?php

// Add user to group as a member
function add_member_to_group($user_id, $group_id) {
    $group_members = get_post_meta($group_id, '_group_members', true);

    if (!$group_members) {
        $group_members = array();
    }

    // Ensure the user is not already a member
    if (!in_array($user_id, $group_members)) {
        $group_members[] = $user_id;
        update_post_meta($group_id, '_group_members', $group_members);
    }
}

// Add a member via a button (front-end form)
function display_add_member_button() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $group_id = get_the_ID(); // Assuming you're on a group page

        if (get_post_type($group_id) === 'group') {
            ob_start();
            ?>
            <form method="POST">
                <input type="submit" name="add_member_to_group" value="Join Group">
            </form>
            <?php
            if (isset($_POST['add_member_to_group'])) {
                add_member_to_group($user_id, $group_id);
            }
            return ob_get_clean();
        }
    }
}
add_shortcode('add_member_button', 'display_add_member_button');
