<?php
/**
 * Plugin Name: Fullerton Faculty Cards
 * Description: A custom plugin that creates the "Faculty" post type for displaying Fullerton College Faculty and Staff using a form.
 * Version: 1.0
 * Author: Brain Jar
 * License: GPL2
 */

// Slug: id? https://www.wpbeginner.com/glossary/post-slug/#:~:text=In%20WordPress%2C%20the%20%E2%80%9Cslug%E2%80%9D,post%E2%80%9D%20is%20the%20post%20slug.

// Set up the arguments, and register The Faculty Post Type
function create_faculty_post_type() {
    // https://developer.wordpress.org/reference/functions/get_post_type_labels/
    $labels = array(
        'name' => __( 'Faculty' ),
        'singular_name' => __( 'Faculty' ),
        'menu_name' => __( 'Faculty' ),
        'add_new' => __( 'Add New' ),
        'add_new_item' => __( 'Add New Faculty' ), // Add new <Post Type Name>
        'edit' => __( 'Edit' ),
        'edit_item' => __( 'Edit Faculty' ), // Edit <Post Type Name>
        'new_item' => __( 'New Faculty' ), // New <Post Type Name>
        'view' => __( 'View Faculty' ), // ?
        'view_item' => __( 'View Faculty' ), // View <Post Type Name>
        'search_items' => __( 'Search Faculty' ), // Search <Post Type Name>
        'not_found' => __( 'No Faculty found' ), // No <Post Type Name> found
        'not_found_in_trash' => __( 'No Faculty found in trash' ),
        'parent' => __( 'Parent Faculty' ), // ?
    );

    // Default arguments - https://developer.wordpress.org/reference/functions/register_post_type/
    // Set public argument to true - https://justintadlock.com/archives/2013/09/13/register-post-type-cheat-sheet
    $args = array(
        'labels' => $labels,
        'public' => true, // Controls how the type is visible to authors (show_in_nav_menus, show_ui) ?
        'has_archive' => true, // the post type name will be used for the archive slug
        'menu_icon' => 'dashicons-groups', // Group of people menu icon
        'supports' => array( 'title', 'editor' ), // Include a title and editor (content) for the post type. We'll add the custom-fields later
        'show_in_rest' => true, // Inclue this post Type in the REST API (make available to the block editor)
    );

    register_post_type( 'faculty', $args );
}

// Register custom post types on the 'init' hook.  
add_action( 'init', 'create_faculty_post_type' );

// Add Meta Form fields
function add_faculty_meta_boxes() {
    // Adds a meta box: https://developer.wordpress.org/reference/functions/add_meta_box/
    add_meta_box(
        'faculty_info', // Unique ID
        'Faculty Information', // Title of the meta box
        'display_faculty_meta_box', // Content callback - fills the box with desired content
        'faculty', // Post type
        'normal', // Context parameter - where the meta box is placed: https://wordpress.stackexchange.com/questions/2026/what-is-the-advanced-context-in-add-meta-box
        'high' // Priority parameter - position the meta box: https://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/
    );
}

// Fires after all built-in meta boxes have been added: https://developer.wordpress.org/reference/hooks/add_meta_boxes/
add_action( 'add_meta_boxes', 'add_faculty_meta_boxes' );

// Output/Display Meta fields to the user
function display_faculty_meta_box( $post ) {

    // Get the current values for these custom fields
    // Retrieves a post meta field for the given post ID: https://developer.wordpress.org/reference/functions/get_post_meta/
    // Parameters: the Post ID, meta key to retrieve, return a single value (- do not return an array of values, just the value of the meta field)
    $name = get_post_meta( $post->ID, 'faculty_name', true );
    $photo_url = get_post_meta( $post->ID, 'faculty_photo_url', true );
    $email = get_post_meta( $post->ID, 'faculty_email', true );
    $phone_number = get_post_meta( $post->ID, 'faculty_phone_number', true );
    $program_name = get_post_meta( $post->ID, 'faculty_program_name', true);
    $office = get_post_meta( $post->ID, 'faculty_office', true);
    $linkedIn = get_post_meta( $post->ID, 'faculty_linkedIn_url', true);

    // Output the fields in the meta box - the HTML form itself when you click "Add new" or "Edit"
    // echo: outputs one or more strings like - echo "your text"; https://www.w3schools.com/php/func_string_echo.asp#:~:text=Definition%20and%20Usage,will%20generate%20a%20parse%20error.
    // esc_attr(): All dynamic data must be escaped with esc_attr() before rendered in an html attribute.  may contain valid data that causes the html to break. A lone double quote would result in invalid markup which may cause the page to render poorly. https://developer.wordpress.com/themes/escaping/  https://wordpress.stackexchange.com/questions/298963/what-is-the-use-of-esc-attr-function
    // < ? php: start php
    // ? > end php
    ?>
    <p>
        <label for="faculty_name">Faculty Name:</label>
        <input type="text" name="faculty_name" value="<?php echo esc_attr( $name ); ?>">
    </p>
    <p>
        <label for="faculty_photo_url">Photo URL:</label>
        <input type="text" name="faculty_photo_url" value="<?php echo esc_attr( $photo_url ); ?>">
    </p>
    <p>
        <label for="faculty_email">Email:</label>
        <input type="email" name="faculty_email" value="<?php echo esc_attr( $email ); ?>">
    </p>
    <p>
        <label for="faculty_phone_number">Phone Number:</label>
        <input type="tel" name="faculty_phone_number" value="<?php echo esc_attr( $phone_number ); ?>">
    </p>
    <p>
        <label for="faculty_program_name">Program Name:</label>
        <input type="text" name="faculty_program_name" value="<?php echo esc_attr( $program_name ); ?>">
    </p>
    <p>
        <label for="faculty_office">Office:</label>
        <input type="text" name="faculty_office" value="<?php echo esc_attr( $office ); ?>">
    </p>
    <p>
        <label for="faculty_linkedIn_url">LinkedIn URL:</label>
        <input type="text" name="faculty_linkedIn_url" value="<?php echo esc_attr( $linkedIn ); ?>">
    </p>
    <?php
}

// Save the custom field data by key when the post is saved
function save_faculty_meta_data( $post_id ) {
    // If this field was submitted, update the post id's meta field with user input

    // isset( $_POST['faculty_name'] ) --> IF the form field with the attribute faculty_name was submitted
    if ( isset( $_POST['faculty_name'] ) ) {
        // sanitize_text_field - Sanitizes a string from user input or from the database. https://developer.wordpress.org/reference/functions/sanitize_text_field/
        $name = sanitize_text_field( $_POST['faculty_name'] );
        // Updates a post meta field based on the given post ID. Parameters - post_id, meta_key name, meta_value to be updated
        update_post_meta( $post_id, 'faculty_name', $name);
    }

    if ( isset( $_POST['faculty_photo_url'] ) ) {
        $photo_url = sanitize_text_field( $_POST['faculty_photo_url'] );
        update_post_meta( $post_id, 'faculty_photo_url', $photo_url );
    }

    if ( isset( $_POST['faculty_email'] ) ) {
        $email = sanitize_email( $_POST['faculty_email'] );
        update_post_meta( $post_id, 'faculty_email', $email );
    }

    if ( isset( $_POST['faculty_phone_number'] ) ) {
        $phone_number = sanitize_text_field( $_POST['faculty_phone_number'] );
        update_post_meta( $post_id, 'faculty_phone_number', $phone_number );
    }

    if ( isset( $_POST['faculty_program_name'] ) ) {
        $program_name = sanitize_text_field( $_POST['faculty_program_name'] );
        update_post_meta( $post_id, 'faculty_program_name', $program_name );
    }

    if ( isset( $_POST['faculty_office'] ) ) {
        $office = sanitize_text_field( $_POST['faculty_office'] );
        update_post_meta( $post_id, 'faculty_office', $office );
    }

    if ( isset( $_POST['faculty_linkedIn_url'] ) ) {
        $linkedIn = sanitize_text_field( $_POST['faculty_linkedIn_url'] );
        update_post_meta( $post_id, 'faculty_linkedIn_url', $linkedIn );
    }
}

// Fires once a post has been saved, specify the post type slug: https://developer.wordpress.org/reference/hooks/save_post_post-post_type/
add_action( 'save_post_faculty', 'save_faculty_meta_data' );

// Save the updated Post's content conditionally
function update_faculty_post_content( $post_id ) {
    // Content Template Start
    $post_content = "<div class='fc-container'>";

    // If the field was submitted AND the input is not empty, append new HTML/data from the user input
    // . =  concatenation operator in php (to update the template, we're concatenating the HTML string for the updated Post content)
    if ( isset( $_POST['faculty_name'] ) && (sanitize_text_field( $_POST['faculty_name'] ) !== "") ) {
        $post_content .= "<div class='fc-header'><div class='fc-header-title'><h4 class='fc-ht-el'>" . sanitize_text_field( $_POST['faculty_name'] ) . "</h4></div></div><div class='fc-content'>";
    }

    if ( isset( $_POST['faculty_photo_url']) && (sanitize_text_field( $_POST['faculty_photo_url'] ) !== "") ) {
        $post_content .= "<p><img class='fc-img' src=" . sanitize_text_field( $_POST['faculty_photo_url'] ) . "></p>";
    }

    if ( isset( $_POST['faculty_program_name'] ) && (sanitize_text_field( $_POST['faculty_program_name'] ) !== "") ) {
        $post_content .= "<p class='fc-program'><b>" . sanitize_text_field( $_POST['faculty_program_name'] ) . "</b></p>";
    }

    if ( isset( $_POST['faculty_office'] ) && (sanitize_text_field( $_POST['faculty_office'] ) !== "") ) {
        $post_content .= "<p class='fc-text'>Office: ". sanitize_text_field( $_POST['faculty_office'] ) . "</p>";
    }

    if ( isset( $_POST['faculty_phone_number'] ) && (sanitize_text_field( $_POST['faculty_phone_number'] ) !== "") ) {
        $post_content .= "<p class='fc-text'>" . sanitize_text_field( $_POST['faculty_phone_number'] ) . "</p>";
    }

    if ( isset( $_POST['faculty_email'] ) && (sanitize_text_field( $_POST['faculty_email'] ) !== "") ) {
        $post_content .= "<p><a class='fc-link' href=mailto:" . sanitize_text_field( $_POST['faculty_email'] ) . ">" . sanitize_text_field( $_POST['faculty_email'] ) . "</a></p>";
    }
    
    if ( isset( $_POST['faculty_linkedIn_url'] ) && (sanitize_text_field( $_POST['faculty_linkedIn_url'] ) !== "") ) {
        $post_content .= "<p><a class='fc-link' href=" . sanitize_text_field( $_POST['faculty_linkedIn_url'] ) . ">LinkedIn Profile</a></p>";
    }

    // Content Template End
    $post_content .= "</div>";
    
    $post_data = array(
        'ID' => $post_id, // The post's id
        'post_content' => $post_content // The post content. Default empty. STRING https://developer.wordpress.org/reference/functions/wp_update_post/
    );

    // Stop that infinate loop :)
    // 20: specify the priority https://wordpress.stackexchange.com/questions/51363/how-to-avoid-infinite-loop-in-save-post-callback
    remove_action( 'save_post_faculty', 'update_faculty_post_content', 20 ); 

    // Updates a post with new post data https://developer.wordpress.org/reference/functions/wp_update_post/
    wp_update_post( $post_data );
    add_action( 'save_post_faculty', 'update_faculty_post_content', 20 );

}

// Fires once a post has been saved, specify the post type slug: https://developer.wordpress.org/reference/hooks/save_post_post-post_type/
add_action( 'save_post_faculty', 'update_faculty_post_content', 20 ); 
