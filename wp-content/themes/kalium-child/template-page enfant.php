<?php
/*
	Template Name: Page Enfant
*/


get_header(); ?>
    <div class="page-wrapper">
        <div id="page-cover-maintainer">
            <div class="page-cover wow animated fadeIn" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post_id, 'full'); ?>)">
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

    </div>

    <?php get_footer() ?>
