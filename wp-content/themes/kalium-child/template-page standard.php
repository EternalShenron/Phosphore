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

<?php
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => 3,
    'post_parent'    => get_post()->ID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );
?>


<div class="container-fluid">
    <div class="row">
        <?php  
            $parent = new WP_Query( $args );
            if ( $parent->have_posts() ) : ?>
                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                    <div class="col-md-4 page-multiple-cover" style="height: 20em; background-image: url(<?php the_post_thumbnail_url() ?>)">4 colonnes</div>
                <?php endwhile; ?>
            <?php endif; wp_reset_query();
        ?>
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
