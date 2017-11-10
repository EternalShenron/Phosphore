<?php
/*
	Template Name: Page Examples
*/
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


get_header(); ?>

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
                                <div class="h3 sibling-pages wow animated fadeInDown" data-wow-duration="0.3s">
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

                <?php 
        // args
        $slider_examples = array(
            'post_type' => 'exemples',
            'posts_per_page' => 12,
            'orderby' => 'menu_order'
        );
        // the query
        $home_example_slider_query = new WP_Query( $slider_examples ); ?>

        <?php if ( $home_example_slider_query->have_posts() ) : ?>
        <section id="page-examples-list" class="">
            <div class="container">
                <div class="h4 text-center">The followings are some examples of topics and results we worked on for our clients.</div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="row wow animated fadeIn">
                        <?php $i = 1 ?>
                        <?php while ( $home_example_slider_query->have_posts() ) : $home_example_slider_query->the_post(); ?>
							<div class="col-xs-12 col-sm-3">
                                <div class="example-item wow animated fadeIn text-center" data-wow-delay="<?php echo $i * 0.12 . 's' ?>" data-wow-offset="100">
                                    <div class="panel-heading" role="tab" id="heading-<?php echo $i ?>">
                                        <a class="example-link" role="button" data-toggle="collapse" href="#example-detail-<?php echo $i ?>" aria-expanded="false" aria-controls="example-detail-<?php echo $i ?>">
                                          <h4><?php the_title() ?></h4>
                                        </a>
	                                </div>
                                    <div class="collapse example-detail" id="example-detail-<?php echo $i ?>" aria-expanded="false" style="height: 0px;">
	                                    <div class="detail-content col-xs-12">
                                            <div class="row">
                                                
                                                <?php get_template_part('element-example') ?>

                                            </div>
	                                    </div>
	                                </div>
                                    <?php edit_post_link() ?>
                                </div>
                            </div>
                            <?php $i++ ?>
                            
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
            
        </section>
        <?php endif; ?>

    </div>


<?php get_footer() ?>