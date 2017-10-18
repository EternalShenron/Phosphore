<?php
/*
	Template Name: Page Enfant
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

    <div class="container-fluid">
        <div class="row" style="background: url(<?php 
echo get_the_post_thumbnail_url( $post_id, 'small'); ?>); height:20em !important;">
            <div class="col-xs-12">
                <div class="row">
                
                 <h2>  <div class="col-xs-12" style="padding-left:1em; padding-bottom:1em">
               <font color="#ffffff"> <?php 
	
                $current = $post->ID;

                $parent = $post->post_parent;

                $grandparent_get = get_post($parent);

                $grandparent = $grandparent_get->post_parent;

                ?>

                <?php if ($root_parent = get_the_title($grandparent) !== $root_parent = get_the_title($current)) {
                    echo get_the_title($grandparent); 
                    }else {
                    echo get_the_title($parent); 
                    }
                     ?> </font>
                    </div></h2> 
                    
                   <h1> <div class="col-xs-12" style="padding-left:1em"> <font color="#ffffff"><?php the_title() ?> </font></div> </h1>
                </div>

            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="padding-top:1em; padding-bottom:2em">8 colonnes
                <?php the_content()?>
            </div>
            <div class="col-lg-4">4 colonnes le sous menu</div>
        </div>
    </div>

    <?php get_footer() ?>
