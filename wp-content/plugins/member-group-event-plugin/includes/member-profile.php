<?php

require_once( plugin_dir_path( __FILE__ ) . 'function.php');

/***
 *  Common Methods 
 */
// Get member profile common fields
// generate_form_field( $type, $name, $label = '', $value = '', $options = array(), $placeholder = '', $attributes = array() )
function cmr_get_member_profile_common_fields() {
    ob_start();
    
    echo generate_form_field( 'text', 'email', 'Email', '', '', 'Enter your email', array( 'required' => 'required' ) );
    echo generate_form_field( 'password', 'password', 'Password', '', '', 'Enter your password', array( 'required' => 'required' ) );
    echo generate_form_field( 'text', 'phone_number', 'Phone Number', '', '', 'Enter your phone number', array( 'required' => 'required' ) );
    echo generate_age_dropdown( 'user_age', '', 'Select Your Age', array( 'required' => 'required' ) );
    ?><h3><?php _e('Location', 'your_text_domain'); ?></h3><?php
    echo generate_form_field( 'text', 'city', 'City', '', '', 'City where you live', array( 'required' => 'required' ) );
    echo generate_form_field( 'text', 'state', 'State', '', '', 'State where you live', array( 'required' => 'required' ) );

    ?><h3><?php _e('Sports Interest', 'your_text_domain'); ?></h3><?php
    echo generate_sports_checkbox( 'user_sports', [], 'Choose your favorite sport', array( 'required' => 'required' ) ); 
    echo generate_skill_level_dropdown( 'skill_level', [], 'Your skill level', array( 'required' => 'required' ) );

    ?><h3><?php _e('Biographical Infomation', 'your_text_domain'); ?></h3><?php
    echo generate_form_field( 'textarea', 'user_about_me', 'About me', '', '', 'Write something about yourself here', array( 'required' => 'required' ) );

    echo generate_form_field( 'file', 'profile_image', 'Profile picture', '', '', 'Choose your profile picture', array( 'required' => 'required' ) ); 
    return ob_get_clean();
}

// Add and update common Fields for Member and Profle
function cmr_add_update_member_profile_common_fields($user_id){

    if (isset($_POST['phone_number'])) {
        update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone_number']));
    }

    if (isset($_POST['user_age'])) {
        update_user_meta($user_id, 'user_age', sanitize_text_field($_POST['user_age']));
    }

    if (isset($_POST['city'])) {
        update_user_meta($user_id, 'city', sanitize_text_field($_POST['city']));
    }

    if (isset($_POST['state'])) {
        update_user_meta($user_id, 'state', sanitize_text_field($_POST['state']));
    }

    if ( isset( $_POST['user_sports'] ) ) {
        // Sanitize the array of selected sports
        $selected_sports = array_map( 'sanitize_text_field', $_POST['user_sports'] );
        update_user_meta($user_id, 'user_sports', $selected_sports);

        // Process the selected sports (save to database, send email, etc.)
    }

    if (isset($_POST['skill_level'])) {
        $selected_skill_level = array_map( 'sanitize_text_field', $_POST['skill_level'] );
        update_user_meta($user_id, 'skill_level', $selected_skill_level);
    }

    if (isset($_POST['user_about_me'])) {
        update_user_meta($user_id, 'user_about_me', sanitize_text_field($_POST['user_about_me']));
    }

    // Handle image upload
    if (isset($_FILES['profile_image'])) {
        $profile_image = $_FILES['profile_image'];
        $uploaded_image_url = upload_profile_image($profile_image);
        update_user_meta($user_id, 'profile_image', $uploaded_image_url);  
    }

}

/***
 *  Member Registration 
 */

// Hook into WordPress initialization to register the form and process form submissions
function cmr_register_member_form() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cmr_register_member'])) {
        cmr_handle_member_registration();
    }
    echo cmr_get_registration_form();
}
add_shortcode('cmr_register_member_form', 'cmr_register_member_form');

// Display registration form
function cmr_get_registration_form() {
    ob_start(); // Start output buffering

    if ( !empty( $errors ) ) {
        foreach ( $errors as $error ) {
            echo '<div class="error-message">' . esc_html( $error ) . '</div>';
        }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
    <h3><?php _e('Personal Information', 'your_text_domain'); ?></h3>
        <?php echo generate_form_field( 'text', 'username', 'Username', '', '', 'Enter your username', array( 'required' => 'required' ) ); 
            echo cmr_get_member_profile_common_fields(); 
        ?>
        <br><input type="submit" name="cmr_register_member" value="Register Member">
    </form>
    <?php
    return ob_get_clean();
}

// Handle the form submission and register the member
function cmr_handle_member_registration() {
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        return; // Prevent processing if the required fields are missing
    }

    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    
    $userdata = array(
        'user_login'    => $username,
        'user_email'    => $email,
        'user_pass'     => $password,
        'role'          => 'subscriber', // Assign role as Subscriber
    );

    // Create the user
    $user_id = wp_insert_user( $userdata );


    
    if (!is_wp_error($user_id)) {
        // If the user was created successfully, add custom fields (user meta)

        cmr_add_update_member_profile_common_fields($user_id);
        
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
        // Handle errors
        $errors[] = $user_id->get_error_message();
    }
}



/***
 *  View user profile
 */


 // Shortcode for displaying search results
function display_users_profile() {
    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );  // Redirect to login page if the user is not logged in
        exit;
    }
    ob_start();
    
    // echo do_shortcode('[display_users_profile]');
    ?>

    <ul>
        <?php 
            // Get the current user's profile image
            $user_id = get_current_user_id();
            $profile_image = get_user_meta($user_id, 'profile_image', true);

            // Display the image if it's set
            if ($profile_image) {
                echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" style="max-width: 150px; height: auto;" />';
            } else {
                // Fallback image if not set
                echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-profile.jpg') . '" alt="Profile Image" style="max-width: 150px; height: auto;" />';
            }

        ?>          
        <li>
            Nickname<br> <b><?php echo esc_attr( wp_get_current_user()->user_login ); ?></b>
        </li>
        <li>
            About me<br> <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_about_me', true ) ); ?></b>
        </li>
        <li>
            Phone Number<br> <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'phone_number', true ) ); ?></b>
        </li>
        <li>
            Age<br> <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_age', true ) ); ?></b>
        </li>
        <li>
            City<br> <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'city', true ) ); ?></b>
        </li>
        <li>
            State<br> <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'state', true ) ); ?></b>
        </li>
        <li>
            Favorite Sports<br> <b>
                <?php
                    $user_sports = get_user_meta( get_current_user_id(), 'user_sports', true );
                    echo is_array($user_sports) ? implode(" ", $user_sports) : '' ;
                    ?>
            </b>
        </li>
        <li>
            Skill level<br> <b>
                <?php 
                    $skil_level =  get_user_meta( get_current_user_id(), 'skill_level', true ); 
                    echo is_array($skil_level) ? implode("", $skil_level) : '';
                ?></b>
        </li>  
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('display_users_profile', 'display_users_profile'); 

function display_fancy_user_profile(){
    
    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );  // Redirect to login page if the user is not logged in
        exit;
    }
    $user_id = get_current_user_id();
    $profile_image = get_user_meta($user_id, 'profile_image', true);

    $profile_image = $profile_image ? esc_url($profile_image) : esc_url(get_template_directory_uri() . '/images/default-profile.jpg');



    ob_start();
    
    // echo do_shortcode('[display_users_profile]');
    ?>

    <div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
    <div class="wp-block-group is-layout-constrained wp-block-group-is-layout-constrained">
    <div class="wp-block-columns is-vk-row-reverse is-layout-flex wp-container-core-columns-is-layout-1 wp-block-columns-is-layout-flex">
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
            <div class="wp-block-vk-blocks-button vk_button vk_button-color-custom vk_button-align-left">
                <a class="vk_button_link btn has-background has-vk-color-primary-background-color btn-md" role="button" aria-pressed="true" rel="noopener">
                <div class="vk_button_link_caption"><span class="vk_button_link_txt">Create Event</span></div>
                </a>
            </div>
        </div>
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
            <div class="wp-block-vk-blocks-button vk_button vk_button-color-custom vk_button-align-left">
                <a class="vk_button_link btn has-background has-vk-color-primary-background-color btn-md" role="button" aria-pressed="true" rel="noopener">
                <div class="vk_button_link_caption"><span class="vk_button_link_txt">Create Group</span></div>
                </a>
            </div>
        </div>
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"></div>
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"></div>
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"></div>
        <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"><h2>Profile</h2></div>
    </div>
    </div>
    <div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
    <div class="wp-block-columns is-layout-flex wp-container-core-columns-is-layout-3 wp-block-columns-is-layout-flex">
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
        <div class="wp-block-vk-blocks-border-box vk_borderBox-background-transparent is-style-vk_borderBox-style-solid-kado-tit-tab">
            <div class="">
                <H5>
                    Nickname -  <b><?php echo esc_attr( wp_get_current_user()->user_login ); ?></b>
                </H5>
                <H5>
                    About me -  <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_about_me', true ) ); ?></b>
                </H5>
                <H5>
                    Phone Number -  <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'phone_number', true ) ); ?></b>
                </H5>
                <H5>
                    Age -  <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_age', true ) ); ?></b>
                </H5>
                <H5>
                    City -  <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'city', true ) ); ?></b>
                </H5>
                <H5>
                    State -  <b><?php echo esc_attr( get_user_meta( get_current_user_id(), 'state', true ) ); ?></b>
                </H5>
                <H5>
                    Favorite Sports -  <b>
                        <?php
                            $user_sports = get_user_meta( get_current_user_id(), 'user_sports', true );
                            echo is_array($user_sports) ? implode(" ", $user_sports) : '' ;
                            ?>
                    </b>
                </H5>
                <H5>
                    Skill level -  <b>
                        <?php 
                            $skil_level =  get_user_meta( get_current_user_id(), 'skill_level', true ); 
                            echo is_array($skil_level) ? implode("", $skil_level) : '';
                        ?></b>
                </H5>  
            </div>
        </div>
        <div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
    </div>
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:40%">
    
        <H5>
    <?php // Display the image if it's set
            if ($profile_image) {
                echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" style="max-width: 400px; height: auto;" />';
            } else {
                // Fallback image if not set
                echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-profile.jpg') . '" alt="Profile Image" style="max-width: 150px; height: auto;" />';
            }?>
            </H5>
        <div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
           
    </div>
    </div>

    <?php
        return ob_get_clean();

}

add_shortcode('display_fancy_user_profile', 'display_fancy_user_profile'); 
/***
 *  Edit user profile button
 */

 // Shortcode to show the Edit Profile button on the user profile page
function front_end_edit_profile_button() {
    // Get the current logged-in user ID
    $current_user_id = get_current_user_id();
    
    // Check if the user is logged in and viewing their own profile page
    if ($current_user_id == get_the_author_meta('ID')) {
        // Get the URL of the front-end profile edit page
        $edit_profile_url = home_url('/edit-profile');  // Update this URL to your front-end profile edit page

        // Display the "Edit Profile" button
        return '<a href="' . esc_url($edit_profile_url) . '" class="button">Edit Profile</a>';
    }

    // If the user is not viewing their own profile, return nothing
    return '';
}
add_shortcode('edit_profile_button', 'front_end_edit_profile_button');
 function edit_users_profile(){

 }
 add_shortcode('edit_users_profile', 'edit_users_profile');

 /***
 *  Edit user profile
 */
