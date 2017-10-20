<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

// After theme setup hooks
function kalium_child_after_setup_theme() {
	// Load translations for child theme
	load_child_theme_textdomain( 'kalium-child', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'kalium_child_after_setup_theme' );



add_filter('acf/settings/show_admin', 'my_acf_show_admin');


/* ENQUEUES */

function kalium_child_enqueue_style() {
    wp_enqueue_style( 'kalium-child', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:400,500,700' );
}

function kalium_child_enqueue_script() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', 'jquery', null, true );
}

add_action( 'wp_enqueue_scripts', 'kalium_child_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'kalium_child_enqueue_script' );



function my_acf_show_admin( $show ) {
   
   return current_user_can('manage_options');
   
}
/*add_filter('acf/settings/show_admin', '__return_true');*/

/* POST TYPES */

add_action( 'init', 'register_exemple' );
    function register_exemple() {
        $labels = array(
            'name' => __( 'Exemples' ),
            'singular_name' => __( 'Exemple' ),
            'add_new' => _x( 'Ajouter', 'exemple' ),
            'add_new_item' => _x( 'Ajouter un exemple', 'exemple' ),
            'edit_item' => _x( 'Modifier la fiche exemple', 'exemple' ),
            'new_item' => _x( 'Nouveau exemple', 'exemple' ),
            'view_item' => _x( 'Voir le exemple', 'exemple' ),
            'search_items' => _x( 'Rechercher un exemple', 'exemple' ),
            'not_found' => _x( 'Aucun exemple trouvé', 'exemple' ),
            'not_found_in_trash' => _x( 'Aucun exemple dans la corbeille', 'exemple' ),
            'parent_item_colon' => _x( 'Exemple parent :', 'exemple' ),
            'menu_name' => _x( 'Exemples', 'exemple' ),
        );
        $args = array (
            'labels' => $labels,
            'hierarchical' => false,
            'description' => 'Les exemples',
            'supports' => array( 'revisions', 'title', 'thumbnail', 'editor' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post'
        );
      register_post_type( 'exemples', $args);
}
