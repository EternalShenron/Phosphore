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

function new_excerpt_more( $more ) {
    return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

add_filter('acf/settings/show_admin', 'my_acf_show_admin');


/* ENQUEUES */

function kalium_child_enqueue_style() {
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:400,500,700' );
    wp_enqueue_style( 'nav-style', get_stylesheet_directory_uri() . '/nav.css' );
    wp_enqueue_style( 'owl-carousel-style', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css' );
    wp_enqueue_style( 'owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css' );
    wp_enqueue_style( 'kalium-child', get_stylesheet_directory_uri() . '/style.css', 'bootstrap-css' );
}

function kalium_child_enqueue_script() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', 'jquery', null, true );
    wp_enqueue_script( 'owl-carousel-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js', 'jquery', null, true );
    wp_enqueue_script( 'match-height', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', 'jquery', null, true );
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


/* Font size dans editeur WYSIWYG */

function wpc_boutons_tinymce($buttons) {
  $buttons[] = 'sub';
  $buttons[] = 'sup';
  $buttons[] = 'fontselect';
  $buttons[] = 'fontsizeselect';
  return $buttons;
}
add_filter("mce_buttons_2", "wpc_boutons_tinymce");

$buttons[] = 'Taille';


// on exécute la fonction avant initialisation de l'éditeur
add_filter( 'tiny_mce_before_init', 'juiz_custom_tinymce' );
 
// la fonction est déclarée si elle n'existe pas déjà
if ( !function_exists('juiz_custom_tinymce')) {
    function juiz_custom_tinymce( $tools ) {
        // on ajoute "styleselect" à une liste d'outils séparés par une virgule
        // on complète ici la seconde ligne d'outils (buttons2)
        $tools['theme_advanced_buttons2'] = 'styleselect,'.$tools['theme_advanced_buttons2'];
 
        // on ajoute des commandes en ligne ou en bloc (box) à notre sélecteur
        $tools['theme_advanced_styles'] = __('Bouton').'=button, '.__('Télécharger').'=download, '.__('Démonstration').'=demo, '.__('Boîte de boutons').'=buttons-box, '.__('Exergue').'=highlight';
 
        // on retourne notre liste d'outils complétée
        return $tools; 
    }
};

// Image sizes
add_image_size( 'medium', 300, 200, true );
add_image_size( 'post-thumb', 360, 240, true );
add_image_size( 'slider-size', 1366, 800, true );