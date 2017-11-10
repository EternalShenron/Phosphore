<?php
/*
	Template Name: Page Formulaire
*/
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


get_header();

// the_content();

?>

    <div class="page-wrapper">
        <div id="page-cover-maintainer">
            <div class="page-cover wow animated fadeIn" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post_id, 'large'); ?>)">
                <div class="container">
                    <?php 
                        $current = $post->ID;
                        $parent = $post->post_parent;
                        $grandparent_get = get_post($parent);
                        $grandparent = $grandparent_get->post_parent;
                    ?>
                    <div class="page-title-group">
                        <div class="h6 parent-page wow animated fadeInDown">
                            <?php 
                                if ($root_parent = get_the_title($grandparent) !== $root_parent = get_the_title($current)) {
                                    echo get_the_title($grandparent); 
                                } else {
                                    echo get_the_title($parent); 
                                }
                            ?>
                        </div>
                        <h1 class="page-title wow animated fadeInUp"><?php the_title() ?></h1>



                        <!-- CRÉATION DU MENU DES PAGES SOEURS -->

                        <!-- On affiche le titre de la page actuelle avant d'appeler les pages soeurs  -->
                        <div class="h3 wow animated fadeInDown" data-wow-duration="0.2s">
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        </div>
                        <?php 
                        // Requête pour aller chercher les pages soeurs
                        //
                        // Paramètres de la requête
                        $sibling_pages = array(
                            'post_parent' => $post->post_parent,    // Param. 1 : Pages dont le parent est le même que la page actuelle
                            'post_type' => 'page',                  // Param. 2 : Seulement les publications de type "page"
                            'post__not_in' => array($current)       // Param. 3 : On exclue la page actuelle
                        ); 

                        // Requête des pages soeurs
                        $sibling_pages_query = new WP_Query( $sibling_pages ); ?>
                        <?php $i = 1 // Initialisation d'une variable $i en vue d'une incrémentation ?>
                        <?php if ( $sibling_pages_query->have_posts() ) : ?>
                            <!-- La Boucle -->
                            <?php while ( $sibling_pages_query->have_posts() ) : $sibling_pages_query->the_post(); ?>

                                <!-- 
                                On affiche les titres des pages soeurs 
                                on incrémente le délai de l'animation pour que les titres s'affichent joliment les uns après les autres
                                -->
                                <div class="h3 sibling-pages wow animated fadeInDown" data-wow-duration="0.3s" data-wow-delay="<?php echo $i * 0.12 . 's' ?>">
                                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                </div>

                                <?php $i = $i+1 // Incrémentation ?>

                            <?php endwhile; ?>
                            <!-- Fin de la Boucle -->
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>


<div class="container">
    <div class="row">
        <div class="col-md-9 col-lg-8 col-center">
            <?php the_content()?>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>


<?php get_footer() ?>