<?php

require_once( plugin_dir_path( __FILE__ ) . 'function.php');

// Shortcode for displaying the Group creation form
function display_registration_form($error) {
    ob_start();
    ?>


    <div class="sample-form-container">
    <h2>Register</h2>
    <?php 
        if($error){
            echo $error;
        }    
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Row 1: Nickname & Email -->
        <div class="form-group-full">
        <label for="sports">Choose your favorite sports</label>
        <?php 
            echo generate_sports_checkbox1( 'user_sports', [], 'Choose your favorite sport', array( 'required' => 'required' ), 'Register' ); 
        ?>
        </div>
        <p class="separator"></p>
        <!-- Row 2: Membership & Skill level -->
        <div class="form-group">
            <?php echo generate_membership_type_dropdown('membership_type','', 'Membership Type', array( 'required' => 'required' )) ?>
        </div>
        <div class="form-group">
            <?php echo generate_skill_level_dropdown( 'skill_level', '', 'Your skill level', array( 'required' => 'required' ) ); ?>
        </div>
        

        <div class="form-group">
            <label for="nickname"><i class="fas fa-user icon"></i>Nickname</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope icon"></i>Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Row 2: Password & Reference -->
        <div class="form-group">
            <label for="nickname">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone_number" name="phone_number" required>
        </div>

        <!-- Row 3: Age & Gender -->
        <div class="form-group">
            <?php  echo generate_age_dropdown('user_age','', 'Your Age', array( 'required' => 'required')); ?>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="I choose not to answer">I choose not to answer</option>
            </select>
        </div>
        <!-- Row 4: City & State -->
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" id="state" name="state" required>
        </div>
        <!-- Row 5: Skill & profile picture  -->
        <div class="form-group">
            <label for="membership_type">Membership Type</label>
            <input type="text" id="membership_type1" name="membership_type1" required>
        </div>
        <div class="form-group">
            <label for="referrer">Referrer</label>
            <input type="text" id="referrer" name="referrer">
        </div>
    

        <!-- Row 6: About Me -->
        <div class="form-group-full">
            <label for="about">About Me</label>
            <textarea id="user_about_me" name="user_about_me" rows="4" required></textarea>
        </div>
         <!-- Row 6: About Me -->
         <div class="form-group-full">
            <p>
            <label for="profile_image">Profile picture</label>
            <input accept="image/*" type="file" name="profile_i" id="profile_image" value="" placeholder="Choose your profile picture" required="required"></p>
        </div>

        <!-- Privacy Policy Checkbox 
        <div class="privacy-policy"> 
            <label for="privacy-policy">
                <input type="checkbox" id="privacy-policy" name="privacy_policy" required>
                I have read and agree to the <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
            </label>
        </div>
        -->

        <!-- Submit Button -->
        <input type="submit" name="submit_registration_form" value="Register Member">
    </form>
</div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'display_registration_form', 'display_registration_form' );

function cmr_handle_member_registration() {



    /*echo '<pre>';
    echo '<br> username - '.sanitize_text_field($_POST['username']);
    echo '<br> email - '.sanitize_email($_POST['email']);
    echo '<br>user_age - '.sanitize_text_field($_POST['user_age']);
    echo '<br> gender - '.sanitize_text_field($_POST['gender']);
    echo '<br> city - '.sanitize_text_field($_POST['city']);
    echo '<br> state - '.sanitize_text_field($_POST['state']);
    echo '<br> referrer - '.sanitize_text_field($_POST['referrer']);
    echo '<br> user_about_me - '.sanitize_textarea_field($_POST['user_about_me']);
    echo '<br> membership_type - '.sanitize_text_field($_POST['membership_type']);
    echo '<br> phone_number - '.sanitize_text_field($_POST['phone_number']);
    echo '<br> user_sports - '.var_dump( $_POST['user_sports']);
    echo '<br> skill_level - '.sanitize_text_field($_POST['skill_level']);
    echo '</pre>';*/

    // Handle form submission (update profile)
    if (isset($_POST['submit_registration_form']) ) {
        $nickname = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_email($_POST['password']);
        $age = sanitize_text_field($_POST['user_age']);
        $gender = sanitize_text_field($_POST['gender']);
        $city = sanitize_text_field($_POST['city']);
        $state = sanitize_text_field($_POST['state']);
        $referrer = sanitize_text_field($_POST['referrer']);
        $about_me = sanitize_textarea_field($_POST['user_about_me']);
        $membership_type = sanitize_text_field($_POST['membership_type']);
        $phone = sanitize_text_field($_POST['phone_number']);
        $sports = isset($_POST['user_sports']) ? $_POST['user_sports'] : [];
        $skill_level = sanitize_text_field($_POST['skill_level']);

        // Update the user data in the database
        $user_data = [
            'user_login' => $nickname,
            'user_email' => $email,
            'nickname' => $nickname,
            'user_pass'     => $password,
            'role'          => 'subscriber', // Assign role as Subscriber
        ];

        $user_id = wp_insert_user($user_data);

        // Update user meta
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'user_age', $age);
            update_user_meta($user_id, 'gender', $gender);
            update_user_meta($user_id, 'city', $city);
            update_user_meta($user_id, 'state', $state);
            update_user_meta($user_id, 'referrer', $referrer);
            update_user_meta($user_id, 'user_about_me', $about_me);
            update_user_meta($user_id, 'membership_type', $membership_type);
            update_user_meta($user_id, 'phone_number', $phone);
            update_user_meta($user_id, 'user_sports', array_map( 'sanitize_text_field', $sports ));
            update_user_meta($user_id, 'skill_level', $skill_level);
            // Handle image upload
            if (isset($_FILES['profile_image'])) {
                $profile_image = $_FILES['profile_image'];
                $uploaded_image_url = upload_profile_image($profile_image);
                update_user_meta($user_id, 'profile_image', $uploaded_image_url);  
            }

            // Optionally, log the user in after successful registration
            wp_set_current_user( $user_id );
            wp_set_auth_cookie( $user_id );

            // Debugging: Ensure redirect works
            // Uncomment to log the redirect URL
            error_log('Redirecting to: ' . home_url('/members'));

            // Send email after successful registration
            $subject = 'Welcome to Our Site!';
            $message = 'Hello ' . $username . ',\n\nWelcome to our website! We are glad to have you as a member.';
            // wp_mail($email, $subject, $message);  // Send email

            wp_redirect(home_url('/members'));
            // Redirect the user to their profile page
            // wp_redirect( get_edit_user_link( $user_id ) );
            
            exit;
        } else {
            return '<p class="error">Error: ' . $user_id->get_error_message() . '</p>';
        }
    }
}

/***
 *  Member Registration 
 */

// Hook into WordPress initialization to register the form and process form submissions
function cmr_register_member_form() {

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_registration_form'])) {
        $error = cmr_handle_member_registration();
    }
    echo display_registration_form($error);
}
add_shortcode('cmr_register_member_form', 'cmr_register_member_form');