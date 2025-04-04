<?php

// Enqueue styles for the form
function custom_registration_form_styles1() {
    echo '<style>
        /* Card-like Form Container */
        .registration-form-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            gap: 15px;
            margin-bottom: 20px;
        }

        .registration-form-row .field {
            flex: 1 1 45%;
            min-width: 250px;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Field Styles */
        .registration-form-row label {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .registration-form-row input,
        .registration-form-row select,
        .registration-form-row textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
            margin-bottom: 12px;
        }

        .registration-form-row textarea {
            resize: vertical;
            min-height: 100px;
        }

        .registration-form-row input[type="file"] {
            padding: 5px;
        }

        /* Submit Button */
        .form-submit {
            text-align: center;
            margin-top: 20px;
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

        /* Responsive Layout */
        @media (max-width: 768px) {
            .registration-form-row .field {
                flex: 1 1 100%;
            }
        }
    </style>';
}
add_action('wp_head', 'custom_registration_form_styles1');

// Shortcode to display the registration form
function custom_registration_form_shortcode3() {

    // Handle form submission
    if (isset($_POST['submit_registration_form'])) {
        // Sanitize and retrieve form data
        $nickname = sanitize_text_field($_POST['nickname']);
        $email = sanitize_email($_POST['email']);
        $age = sanitize_text_field($_POST['age']);
        $gender = sanitize_text_field($_POST['gender']);
        $phone = sanitize_text_field($_POST['phone']);
        $sports = isset($_POST['sports']) ? $_POST['sports'] : [];
        $city = sanitize_text_field($_POST['city']);
        $state = sanitize_text_field($_POST['state']);
        $about_me = sanitize_textarea_field($_POST['about_me']);

        // Handle the user registration
        $user_data = array(
            'user_login' => $nickname,
            'user_email' => $email,
            'nickname' => $nickname,
            'user_pass' => wp_generate_password(),
        );

        $user_id = wp_insert_user($user_data);

        if (!is_wp_error($user_id)) {
            // Save user meta data
            update_user_meta($user_id, 'age', $age);
            update_user_meta($user_id, 'gender', $gender);
            update_user_meta($user_id, 'phone', $phone);
            update_user_meta($user_id, 'sports', implode(', ', $sports));
            update_user_meta($user_id, 'city', $city);
            update_user_meta($user_id, 'state', $state);
            update_user_meta($user_id, 'about_me', $about_me);

            // Success message
            echo '<div class="registration-success">Registration successful! You can now log in.</div>';
        } else {
            echo '<div class="registration-error">Error: ' . $user_id->get_error_message() . '</div>';
        }
    }

    // Registration form HTML
    ob_start();
    ?>
    <div class="registration-form-container">
        <h2>Create an Account</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="registration-form-row">
                <!-- Nickname and Email -->
                <div class="field">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" id="nickname" required>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Age and Gender -->
                <div class="field">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" required>
                </div>

                <div class="field">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- Phone and Sports -->
                <div class="field">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" required>
                </div>

                <div class="field">
                    <label for="sports">Sports</label>
                    <select name="sports[]" id="sports" multiple>
                        <option value="Basketball">Basketball</option>
                        <option value="Football">Football</option>
                        <option value="Baseball">Baseball</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Swimming">Swimming</option>
                        <option value="Volleyball">Volleyball</option>
                    </select>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- City and State -->
                <div class="field">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" required>
                </div>

                <div class="field">
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" required>
                </div>
            </div>

            <div class="registration-form-row">
                <!-- About Me -->
                <div class="field">
                    <label for="about_me">About Me</label>
                    <textarea name="about_me" id="about_me"></textarea>
                </div>
            </div>

            <div class="form-submit">
                <button type="submit" name="submit_registration_form">Register</button>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration_form_shortcode3', 'custom_registration_form_shortcode3');
