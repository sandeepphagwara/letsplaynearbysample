<?php

require_once( plugin_dir_path( __FILE__ ) . 'function.php');

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



function display_fancy_user_profile2(){

    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );  // Redirect to login page if the user is not logged in
        exit;
    }
    ob_start();
    
    // echo do_shortcode('[display_users_profile]');
 
    // Get the current user's profile image
    $user_id = get_current_user_id();
    $profile_image = get_user_meta($user_id, 'profile_image', true);
    $profile_image = $profile_image ? esc_url($profile_image) : esc_url(get_template_directory_uri() . '/images/default-profile.jpg');
    ?> 

    <div class="profile-container">
        <div class="left-sidebar">
            <div class="profile-image-wrapper">
                <?php echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" class="profile-image" />'; ?>
            </div>
            <h3><?php echo esc_attr( strtoupper(wp_get_current_user()->user_login) ); ?></h3>
            <p><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_age', true ) ); ?>, <?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_gender', true ) ); ?></p>
            <p><?php echo esc_attr( get_user_meta( get_current_user_id(), 'city', true ) ); ?>, <?php echo esc_attr( get_user_meta( get_current_user_id(), 'state', true ) ); ?></p>
            <p><?php echo esc_attr( (get_user_meta( get_current_user_id(), 'phone_number', true )) ); ?>, <?php echo esc_attr( wp_get_current_user()->user_email ); ?></p>
        </div>

        <div class="right-column">
            <h3>About Me</h3>
            <p><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_about_me', true ) ); ?></p>
            <h3>Sports - <?php 
                    $skil_level =  get_user_meta( get_current_user_id(), 'skill_level', true ); 
                    echo is_array($skil_level) ? implode("", $skil_level) : '';
                ?></h3>
                <p><?php
                    $user_sports = get_user_meta( get_current_user_id(), 'user_sports', true );
                    echo is_array($user_sports) ? implode(" ", $user_sports) : '' ;
                    ?></p>
            <h5>My Groups</h5>
            <p>5 years of experience in frontend development...</p>
            <h5>My Events</h5>
            <p>5 years of experience in frontend development...</p>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('display_fancy_user_profile2', 'display_fancy_user_profile2'); 

/**
 * 

function display_fancy_user_profile2(){

    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );  // Redirect to login page if the user is not logged in
        exit;
    }
    ob_start();
    
    // echo do_shortcode('[display_users_profile]');
 
    // Get the current user's profile image
    $user_id = get_current_user_id();
    $profile_image = get_user_meta($user_id, 'profile_image', true);
    ?>  
        
        <div class="profile-container">
            <div class="profile-header">
                <img src="profile-image.jpg" alt="Profile Picture" class="profile-image">
                <?php
                    if ($profile_image) {
                        echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" class="profile-image" />';
                    } else {
                        // Fallback image if not set
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-profile.jpg') . '" alt="Profile Image" class="profile-image" />';
                    }
                ?>
                <div class="profile-info">
                    <h2 class="username"><?php echo esc_attr( wp_get_current_user()->user_login ); ?></h2>
                    <p class="age">Age: <?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_age', true ) ); ?></p>
                    <p class="gender">Gender: Male</p>
                </div>
            </div>
            
            <div class="contact-info">
                <p class="phone">Phone: <?php echo esc_attr( get_user_meta( get_current_user_id(), 'phone_number', true ) ); ?></p>
                <p class="city">City: <?php echo esc_attr( get_user_meta( get_current_user_id(), 'city', true ) ); ?></p>
                <p class="state">State: <?php echo esc_attr( get_user_meta( get_current_user_id(), 'state', true ) ); ?></p>
            </div>

            <div class="sports-info">
                <p class="sports">Sports: <?php
                    $user_sports = get_user_meta( get_current_user_id(), 'user_sports', true );
                    echo is_array($user_sports) ? implode(" ", $user_sports) : '' ;
                    ?>
                </p>
                <p class="sports">Skill level:  <?php 
                    $skil_level =  get_user_meta( get_current_user_id(), 'skill_level', true ); 
                    echo is_array($skil_level) ? implode("", $skil_level) : '';
                ?>
                </p>
            </div>

            <div class="description">
                <h3>About me</h3>
                <p><?php echo esc_attr( get_user_meta( get_current_user_id(), 'user_about_me', true ) ); ?></p>
            </div>
        </div>
    <?php
    return ob_get_clean();
}

add_shortcode('display_fancy_user_profile2', 'display_fancy_user_profile2'); 

 */


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
