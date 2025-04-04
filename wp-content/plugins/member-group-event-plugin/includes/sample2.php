<?php
/**
 * Plugin Name: Custom Registration and profile update
 * Description: A custom registration form with multiple fields, now with profile update functionality.
 * Version: 1.1
 * Author: Your Name
 */

// Enqueue styles for the form
function custom_registration_form_styles() {
    echo '<style>
        /* General Form Container */
        .registration-form-container { 
            max-width: 900px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #f9f9f9; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .registration-form-container h2 { 
            text-align: center; 
            margin-bottom: 30px; 
            font-size: 24px; 
            color: #333;
        }
        
        /* Form Row Layout */
        .registration-form-row { 
            display: flex; 
            flex-wrap: wrap; 
            margin-bottom: 20px; 
        }
        .registration-form-row .field { 
            flex: 1 1 45%; 
            margin-right: 10%; 
        }
        .registration-form-row .field:last-child { 
            margin-right: 0; 
        }
        .registration-form-row label { 
            font-weight: bold; 
            color: #333; 
            margin-bottom: 5px;
        }
        
        /* Form Fields */
        .registration-form-row input, 
        .registration-form-row select, 
        .registration-form-row textarea { 
            width: 100%; 
            padding: 12px 15px; 
            font-size: 14px; 
            border-radius: 5px; 
            border: 1px solid #ddd; 
            background-color: #fff;
            margin-bottom: 10px;
        }

        /* File Upload */
        .registration-form-row input[type="file"] { 
            padding: 3px; 
        }
        
        /* Checkbox Styling */
        .registration-form-row input[type="checkbox"] { 
            margin-right: 10px; 
        }

        /* Submit Button */
        .form-submit { 
            text-align: center; 
        }
        .form-submit button { 
            padding: 12px 20px; 
            background-color: #0073aa; 
            color: white; 
            border: none; 
            font-size: 16px; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        .form-submit button:hover { 
            background-color: #005d8c; 
        }
        
        /* Profile Picture */
        .profile-picture-wrapper { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
        }
        .profile-picture-wrapper img { 
            max-width: 150px; 
            border-radius: 50%; 
            margin-bottom: 10px; 
        }
        .profile-picture-wrapper input[type="file"] { 
            margin-top: 10px; 
        }

        /* Media Query for Responsive Layout */
        @media (max-width: 768px) {
            .registration-form-row .field { 
                flex: 1 1 100%; 
                margin-right: 0; 
            }
        }
    </style>';
}
add_action('wp_head', 'custom_registration_form_styles');

// Shortcode to display the registration or profile update form
function custom_registration_form_shortcode() {
    // Check if user is logged in
    $current_user = wp_get_current_user();
    $is_logged_in = is_user_logged_in();

    if ($is_logged_in) {
        // Pre-fill user data if logged in
        $nickname = $current_user->nickname;
        $email = $current_user->user_email;
        $age = get_user_meta($current_user->ID, 'age', true);
        $gender = get_user_meta($current_user->ID, 'gender', true);
        $city = get_user_meta($current_user->ID, 'city', true);
        $state = get_user_meta($current_user->ID, 'state', true);
        $referrer = get_user_meta($current_user->ID, 'referrer', true);
        $about_me = get_user_meta($current_user->ID, 'about_me', true);
        $membership_type = get_user_meta($current_user->ID, 'membership_type', true);
        $phone = get_user_meta($current_user->ID, 'phone', true);
        $sports = get_user_meta($current_user->ID, 'sports', true);
        $skill_level = get_user_meta($current_user->ID, 'skill_level', true);
        $profile_picture = get_user_meta($current_user->ID, 'profile_picture', true);
    } else {
        // Redirect if user is not logged in
        return '<p>You need to be logged in to update your profile.</p>';
    }

    // Handle form submission (update profile)
    if (isset($_POST['submit_registration_form'])) {
        $nickname = sanitize_text_field($_POST['nickname']);
        $email = sanitize_email($_POST['email']);
        $age = sanitize_text_field($_POST['age']);
        $gender = sanitize_text_field($_POST['gender']);
        $city = sanitize_text_field($_POST['city']);
        $state = sanitize_text_field($_POST['state']);
        $referrer = sanitize_text_field($_POST['referrer']);
        $about_me = sanitize_textarea_field($_POST['about_me']);
        $membership_type = sanitize_text_field($_POST['membership_type']);
        $phone = sanitize_text_field($_POST['phone']);
        $sports = isset($_POST['sports']) ? $_POST['sports'] : [];
        $skill_level = sanitize_text_field($_POST['skill_level']);

        // Handle file upload for profile picture
        if (!empty($_FILES['profile_picture']['name'])) {
            $uploaded = media_handle_upload('profile_picture', 0);
            if (!is_wp_error($uploaded)) {
                $profile_picture = wp_get_attachment_url($uploaded);
            }
        }

        // Update the user data in the database
        $user_data = [
            'ID' => $current_user->ID,
            'user_login' => $nickname,
            'user_email' => $email,
            'nickname' => $nickname,
        ];

        $user_id = wp_update_user($user_data);

        // Update user meta
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'age', $age);
            update_user_meta($user_id, 'gender', $gender);
            update_user_meta($user_id, 'city', $city);
            update_user_meta($user_id, 'state', $state);
            update_user_meta($user_id, 'referrer', $referrer);
            update_user_meta($user_id, 'about_me', $about_me);
            update_user_meta($user_id, 'membership_type', $membership_type);
            update_user_meta($user_id, 'phone', $phone);
            update_user_meta($user_id, 'sports', implode(', ', $sports));
            update_user_meta($user_id, 'skill_level', $skill_level);
            update_user_meta($user_id, 'profile_picture', $profile_picture);

            echo '<p>Profile updated successfully!</p>';
        } else {
            echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
        }
    }

    // Form HTML
    ob_start();
    ?>
    <div class="registration-form-container">
        <h2>Update Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="registration-form-row">
                <!-- Sports and Skill Level -->
                <div class="field">
                    <label for="sports">Sports</label>
                    <select name="sports[]" id="sports" multiple>
                        <option value="Basketball" <?php if (in_array('Basketball', explode(', ', $sports))) echo 'selected'; ?>>Basketball</option>
                        <option value="Football" <?php if (in_array('Football', explode(', ', $sports))) echo 'selected'; ?>>Football</option>
                        <option value="Baseball" <?php if (in_array('Baseball', explode(', ', $sports))) echo 'selected'; ?>>Baseball</option>
                        <option value="Tennis" <?php if (in_array('Tennis', explode(', ', $sports))) echo 'selected'; ?>>Tennis</option>
                        <option value="Swimming" <?php if (in_array('Swimming', explode(', ', $sports))) echo 'selected'; ?>>Swimming</option>
                        <option value="Volleyball" <?php if (in_array('Volleyball', explode(', ', $sports))) echo 'selected'; ?>>Volleyball</option>
                    </select>
                </div>

                <div class="field">
                    <label for="skill_level">Skill Level</label>
                    <select name="skill_level" id="skill_level">
                        <option value="Beginner" <?php if ($skill_level == 'Beginner') echo 'selected'; ?>>Beginner</option>
                        <option value="Intermediate" <?php if ($skill_level == 'Intermediate') echo 'selected'; ?>>Intermediate</option>
                        <option value="Advanced" <?php if ($skill_level == 'Advanced') echo 'selected'; ?>>Advanced</option>
                    </select>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Nickname and Email -->
                <div class="field">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($nickname); ?>" required>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo esc_attr($email); ?>" required>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Password and Age -->
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="field">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo esc_attr($age); ?>" required>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Gender and City -->
                <div class="field">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>

                <div class="field">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" value="<?php echo esc_attr($city); ?>" required>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- State and Referrer -->
                <div class="field">
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" value="<?php echo esc_attr($state); ?>" required>
                </div>

                <div class="field">
                    <label for="referrer">Referrer</label>
                    <input type="text" name="referrer" id="referrer" value="<?php echo esc_attr($referrer); ?>">
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Profile Picture and About Me -->
                <div class="field profile-picture-wrapper">
                    <label for="profile_picture">Profile Picture</label>
                    <?php if ($profile_picture): ?>
                        <img src="<?php echo esc_url($profile_picture); ?>" alt="Profile Picture">
                    <?php endif; ?>
                    <input type="file" name="profile_picture" id="profile_picture">
                </div>

                <div class="field">
                    <label for="about_me">About Me</label>
                    <textarea name="about_me" id="about_me"><?php echo esc_textarea($about_me); ?></textarea>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Membership Type and Phone -->
                <div class="field">
                    <label for="membership_type">Membership Type</label>
                    <select name="membership_type" id="membership_type">
                        <option value="Free" <?php if ($membership_type == 'Free') echo 'selected'; ?>>Free</option>
                        <option value="Paid" <?php if ($membership_type == 'Paid') echo 'selected'; ?>>Paid</option>
                    </select>
                </div>

                <div class="field">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo esc_attr($phone); ?>" required>
                </div>
            </div>

            <div class="form-submit">
                <button type="submit" name="submit_registration_form">Update Profile</button>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration_form_shortcode', 'custom_registration_form_shortcode');
