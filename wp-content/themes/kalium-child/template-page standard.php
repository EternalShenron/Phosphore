<?php
/*
	Template Name: Page Standard
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

    <?php
/*Sub header personnalisÃ©*/ ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 hidden-xs hidden-sm">4 colonnes</div>
                <div class="col-xs-12 col-md-4" style="background: url(<?php 
echo get_the_post_thumbnail_url( $post_id, 'small'); ?>) ;background-repeat:no-repeat; height:10em !important;">
                    <?php the_title() ?>
                </div>
                <div class="col-md-4 hidden-xs hidden-sm"> 4 colonnes</div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-8">8 colonnes contenu de l'article
                    <?php the_content()?>
                </div>
                <div class="col-lg-4">4 colonnes le sous menu </div>
            </div>
        </div>


        <?php get_footer() ?>
