<?php

function generate_form_field( $type, $name, $label = '', $value = '', $options = array(), $placeholder = '', $attributes = array() ) {
    $html = '';

    // Add common attributes to fields
    $attrs = '';
    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $key => $attr_value ) {
            $attrs .= ' ' . esc_attr( $key ) . '="' . esc_attr( $attr_value ) . '"';
        }
    }

    switch ( $type ) {
        case 'text':
        case 'email':
        case 'password':
            $html .= '<p>';
            $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
            $html .= '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '" ' . $attrs . ' />';
            $html .= '</p>';
            break;

        case 'file':
            $html .= '<p>';
            $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label><br>';
            $html .= '<input accept="image/*" type="' . esc_attr( $type ) . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '" ' . $attrs . ' />';
            $html .= '</p>';
            break;
        
            case 'textarea':
            $html .= '<p>';
            $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
            $html .= '<textarea name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" placeholder="' . esc_attr( $placeholder ) . '" ' . $attrs . '>' . esc_textarea( $value ) . '</textarea>';
            $html .= '</p>';
            break;

        case 'select':
            $html .= '<p>';
            $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
            $html .= '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" ' . $attrs . '>';
            foreach ( $options as $key => $option_label ) {
                $html .= '<option value="' . esc_attr( $key ) . '" ' . selected( $value, $key, false ) . '>' . esc_html( $option_label ) . '</option>';
            }
            $html .= '</select>';
            $html .= '</p>';
            break;

        case 'checkbox':
            $html .= '<p>';
            $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
            $html .= '<input type="checkbox" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="1" ' . checked( $value, 1, false ) . ' ' . $attrs . ' />';
            $html .= '</p>';
            break;

        case 'radio':
            $html .= '<p>';
            $html .= '<label>' . esc_html( $label ) . '</label>';
            foreach ( $options as $key => $option_label ) {
                $html .= '<label>';
                $html .= '<input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $key ) . '" ' . checked( $value, $key, false ) . ' ' . $attrs . ' /> ';
                $html .= esc_html( $option_label );
                $html .= '</label><br>';
            }
            $html .= '</p>';
            break;

        case 'hidden':
            $html .= '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
            break;

        default:
            $html .= '<p><strong>Unsupported field type: ' . esc_html( $type ) . '</strong></p>';
            break;
    }

    return $html;
}

function generate_skill_level_dropdown( $name, $selected_values ='', $label = 'Select Your Skilllevel', $attributes = array() ) {
    // List of sports for the dropdown
    $skill_level_options = array(
        'Beginner' => 'Beginner',
        'Intermediate' => 'Intermediate',
        'Advanced' => 'Advanced',
        'Expert' => 'Expert',
        'Recreational' => 'Recreational',
        'Competitive' => 'Competitive'
    );

    // Start building the HTML for the dropdown field
    $html = '<p>';
    $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
    $html .= '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '"';

    // Add extra attributes (e.g., required, etc.)
    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $key => $attr_value ) {
            $html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $attr_value ) . '"';
        }
    }

    $html .= '>';

    // Loop through the sports options and create <option> elements
    foreach ( $skill_level_options as $key => $skill_level ) {
        $html .= '<option value="' . esc_attr( $key ) . '" ' . ( ( $key === $selected_values ) ? 'selected="selected"' : '' ) . '>' . esc_html( $skill_level ) . '</option>';
    }

    $html .= '</select>';
    $html .= '</p>';

    return $html;
}

function generate_membership_type_dropdown( $name, $selected_values ='', $label = 'Membership Type', $attributes = array() ) {
    // List of sports for the dropdown
    $membership_type_options = array(
        'Player' => 'Player',
        'Coach' => 'Coach',
        'Trainer' => 'Trainer',
        'Physically Challenged Player' => 'Physically Challenged Player',
        'Sports Complex Owner' => 'Sports Complex Owner',
    );

    // Start building the HTML for the dropdown field
    $html = '';
    $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
    $html .= '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '"';

    // Add extra attributes (e.g., required, etc.)
    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $key => $attr_value ) {
            $html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $attr_value ) . '"';
        }
    }

    $html .= '>';

    // Loop through the sports options and create <option> elements
    foreach ( $membership_type_options as $key => $membership_type ) {
        $html .= '<option value="' . esc_attr( $key ) . '" ' . ( ( $key === $selected_values ) ? 'selected="selected"' : '' ) . '>' . esc_html( $membership_type ) . '</option>';
    }

    $html .= '</select>';

    return $html;
}

function generate_sports_checkbox( $name, $selected_values = array(), $label = 'Select Your Sports', $attributes = array() ) {
    // List of sports for the checkboxes
    $sports_options = array(
        'Badminton' => 'Badminton',
        'Tennis' => 'Tennis',
        'Football' => 'Football',
        'Basketball' => 'Basketball',
        'Cricket' => 'Cricket',
        'Volleyball' => 'Volleyball'
    );

    // Start building the HTML for the checkboxes
    $html = '';
    $html .= '<label>' . esc_html( $label ) . '</label><br>';

    // Loop through the sports options and create <input type="checkbox">
    foreach ( $sports_options as $key => $sport ) {
        $html .= '<label for="' . esc_attr( $key ) . '">';
        $html .= '<input type="checkbox" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $selected_values ) ? 'checked="checked"' : '' ) . ' /> ' . esc_html( $sport );
        $html .= '</label><br>';
    }

    return $html;
}


function generate_sports_checkbox1( $name, $selected_values = array(), $label = 'Select Your Sports', $attributes = array(), $style= 'Register' ) {
    // List of sports for the checkboxes
    $sports = [
        ["name" => "Badminton", "icon" => "fas fa-shuttlecock"],
        ["name" => "Football", "icon" => "fas fa-football-ball"],
        ["name" => "Baseball", "icon" => "fas fa-baseball-ball"],
        ["name" => "Tennis", "icon" => "fas fa-tennis-ball"],
        ["name" => "Table Tennis", "icon" => "fas fa-table-tennis"],
        ["name" => "Pickel Ball", "icon" => "fas fa-pickleball"],
        ["name" => "Squash", "icon" => "fas fa-squash-ball"],
        ["name" => "Swimming", "icon" => "fas fa-swimmer"],
        ["name" => "Basketball", "icon" => "fas fa-basketball-ball"],
        [ "name" => "Golf", "icon" => "fas fa-golf-ball"],
        ["name" => "Hiking", "icon" => "fas fa-hiking"],
        ["name" => "Walking", "icon" => "fas fa-walking"],
        ["name" => "Running", "icon" => "fas fa-running"],
        ["name" => "Yoga", "icon" => "fas fa-user"],
        ["name" => "Polo", "icon" => "fas fa-golf-flag-hole"],
        ["name" => "Cycling", "icon" => "fas fa-bicycle"],
        ["name" => "Hockey", "icon" => "fas fa-hockey-puck"],
        ["name" => "Ice Hockey", "icon" => "fas fa-hockey-puck"],
        ["name" => "Boxing", "icon" => "fas fa-glove-boxing"],
        ["name" => "Rowing", "icon" => "fas fa-rowing"],
        ["name" => "Mountain trailer", "icon" => "fas fa-hiking"],
        ["name" => "Marathon", "icon" => "fas fa-running"],
        ["name" => "Cricket", "icon" => "fas fa-cricket"],

    ];

    $html = '<div class="sports-container">';
    // Loop through the sports array to create checkbox options
    if($style == 'Register'){
        foreach ($sports as $sport) {
            $html .= '<div class="sport-card">';
            $html .= '<i class="' . $sport['icon'] . '"></i>';
            $html .= '<h3>' . $sport['name'] . '</h3>';
            $html .= '<label>';
            $html .= '<input type="checkbox" name="user_sports[]" value="' . $sport['name'] . '" > Select';
            $html .= '</label>';
            $html .= '</div>';
        }
    }
    if($style == 'Search'){
        foreach ($sports as $sport) {
            $html .= '<div class="sport-card-search">';
            $html .= '';
            $html .= '<input type="checkbox" name="user_sports[]" id="' . $sport['name'] . '"    value="' . $sport['name'] . '">';
            $html .= '<label for="' . $sport['name'] . '"><i class="' . $sport['icon'] . ' icon"></i>'. $sport['name'];
            $html .= '</label></div>';
        }
    }
   
  
    $html .='</div>';

    return $html;
}



function generate_age_dropdown( $name, $selected_value = '', $label = 'Select Your Age', $attributes = array() ) {
    // Define the range of ages (e.g., from 18 to 100)
    $age_range = range( 10, 100 );

    // Start building the HTML for the dropdown field
    $html = '';
    $html .= '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
    $html .= '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" ';

    // Add extra attributes to the select element (like required, disabled, etc.)
    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $key => $attr_value ) {
            $html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $attr_value ) . '"';
        }
    }

    $html .= '>';

    // Loop through the age range to create <option> elements
    foreach ( $age_range as $age ) {
        $html .= '<option value="' . esc_attr( $age ) . '" ' . selected( $selected_value, $age, false ) . '>' . esc_html( $age ) . '</option>';
    }

    $html .= '</select>';

    return $html;
}

function display_user_sports( $user_id ) {
    $sports = get_user_meta( $user_id, 'user_sports', true );
    
    if ( ! empty( $sports ) ) {
        echo 'Selected Sports: ' . implode( ', ', $sports );
    } else {
        echo 'No sports selected.';
    }
}

/*
// Add the Profile Image field to the user profile
function custom_user_profile_fields($user) {
    ?>
    <h3><?php _e('Profile Image', 'your_text_domain'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="profile_image"><?php _e('Profile Image', 'your_text_domain'); ?></label></th>
            <td>
                <?php
                // Get the current user profile image
                $profile_image = get_user_meta($user->ID, 'profile_image', true);
                if ($profile_image) {
                    echo '<img src="' . esc_url($profile_image) . '" alt="Profile Image" style="max-width: 150px; margin-bottom: 10px;"/>';
                }
                ?>
                <br />
                <input type="button" name="upload_image_button" id="upload_image_button" class="button" value="Upload Image" />
                <input type="text" name="profile_image" id="profile_image" value="<?php echo esc_url($profile_image); ?>" class="regular-text" readonly />
                <br />
                <span class="description"><?php _e('Upload your profile image here.', 'your_text_domain'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');

// Save the Profile Image
function save_profile_image($user_id) {
    if (isset($_POST['profile_image'])) {
        update_user_meta($user_id, 'profile_image', esc_url_raw($_POST['profile_image']));
    }
}
add_action('personal_options_update', 'save_profile_image');
add_action('edit_user_profile_update', 'save_profile_image');
// Enqueue media uploader scripts
function enqueue_media_uploader_script($hook_suffix) {
    // Check if we're on the user profile page
    if ('user-edit.php' === $hook_suffix || 'profile.php' === $hook_suffix || true) {
        wp_enqueue_script('jquery');
        wp_enqueue_media();
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            var mediaUploader;
            
            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                
                // If the uploader object exists, reuse it
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                // Create a new media uploader
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose a Profile Image',
                    button: {
                        text: 'Select Image'
                    },
                    multiple: false
                });
                
                // When an image is selected, run this function
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#profile_image').val(attachment.url); // Update the input field with the image URL
                    $('img').remove(); // Remove the old image
                    $('#upload_image_button').before('<img src="' + attachment.url + '" style="max-width: 150px; margin-top: 10px;"/>');
                });
                
                mediaUploader.open();
            });
        });
        </script>
        <?php
    }
}
add_action('wp_enqueue_scripts', 'enqueue_media_uploader_script');
*/


// Handle the profile image upload
function upload_profile_image($file) {
    // Check for image file type
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir(); // Get the upload directory
        $target_dir = $upload_dir['path'] . '/'; // Path to save the image

        // Get the file's name and extension
        $file_name = sanitize_file_name($file['name']);
        $file_tmp = $file['tmp_name'];

        // Set up the file path to save the image in the correct folder
        $target_file = $target_dir . $file_name;

        // Check if the file is an image (for security reasons)
        $image_type = exif_imagetype($file_tmp);
        if (in_array($image_type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            // Move the file to the uploads directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Insert the image into the WordPress media library
                $attachment = array(
                    'post_mime_type' => $file['type'],
                    'post_title' => sanitize_file_name($file_name),
                    'post_content' => '',
                    'post_status' => 'inherit',
                );
                $attachment_id = wp_insert_attachment($attachment, $target_file);

                // Generate metadata for the image
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $target_file);
                wp_update_attachment_metadata($attachment_id, $attachment_data);

                // Return the URL of the uploaded image
                return $upload_dir['url'] . '/' . $file_name;
            } else {
                return false; // Error during upload
            }
        } else {
            return false; // Not a valid image file
        }
    }
    return false; // No file or upload error
}

?>