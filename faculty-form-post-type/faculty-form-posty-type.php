<?php
/**
 * Plugin Name: Fullerton Faculty Cards
 * Description: A custom plugin that creates the "Faculty" post type for displaying Fullerton College Faculty and Staff using a form.
 * Version: 1.0
 * Author: Brain Jar
 * License: GPL2
 */

// Register The Faculty Post Type
function create_faculty_post_type() {
    $labels = array(
        'name' => __( 'Faculty' ),
        'singular_name' => __( 'Faculty' ),
        'menu_name' => __( 'Faculty' ),
        'add_new' => __( 'Add New' ),
        'add_new_item' => __( 'Add New Faculty' ),
        'edit' => __( 'Edit' ),
        'edit_item' => __( 'Edit Faculty' ),
        'new_item' => __( 'New Faculty' ),
        'view' => __( 'View Faculty' ),
        'view_item' => __( 'View Faculty' ),
        'search_items' => __( 'Search Faculty' ),
        'not_found' => __( 'No Faculty found' ),
        'not_found_in_trash' => __( 'No Faculty found in trash' ),
        'parent' => __( 'Parent Faculty' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array( 'title', 'editor' ),
        'show_in_rest' => true, // Inclue this post Type in the REST API (make available to the block editor)
    );

    register_post_type( 'faculty', $args );
}

// Hooking up our function to theme setup   
add_action( 'init', 'create_faculty_post_type' );

// Add Meta Form fields
function add_faculty_meta_boxes() {
    // Create Meta Box
    add_meta_box(
        'faculty_info', // Unique ID
        'Faculty Information', 
        'display_faculty_meta_box', // Content callback
        'faculty', // Post type
        'normal', 
        'high' 
    );
}

add_action( 'add_meta_boxes', 'add_faculty_meta_boxes' );

// Output/Display Meta fields to the user
function display_faculty_meta_box( $post ) {

    // Get the current values for these custom fields
    $name = get_post_meta( $post->ID, 'faculty_name', true );
    $photo_url = get_post_meta( $post->ID, 'faculty_photo_url', true );
    $email = get_post_meta( $post->ID, 'faculty_email', true );
    $phone_number = get_post_meta( $post->ID, 'faculty_phone_number', true );
    $program_name = get_post_meta( $post->ID, 'faculty_program_name', true);
    $office = get_post_meta( $post->ID, 'faculty_office', true);
    $linkedIn = get_post_meta( $post->ID, 'faculty_linkedIn_url', true);

    // Output the fields in the meta box
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
    // If this field was submitted, update the meta field
    if ( isset( $_POST['faculty_name'] ) ) {
        $name = sanitize_text_field( $_POST['faculty_name'] );
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

add_action( 'save_post_faculty', 'save_faculty_meta_data' );

// Save the updated Post's content conditionally
function update_faculty_post_content( $post_id ) {
    // Content Template Start
    $post_content = "<div class='fc-container'>";

    // If the field was submitted AND the input is not empty, update the template by user input
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
        'ID' => $post_id,
        'post_content' => $post_content
    );

    // Stop that infinate loop :)
    remove_action( 'save_post_faculty', 'update_faculty_post_content', 20 );
    wp_update_post( $post_data );
    add_action( 'save_post_faculty', 'update_faculty_post_content', 20 );

}

add_action( 'save_post_faculty', 'update_faculty_post_content', 20 );
