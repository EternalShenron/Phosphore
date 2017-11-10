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
 );
?>



        <div id="page-cover-maintainer">
            <div class="page-cover wow animated fadeIn">
                <div class="container">
                    <?php 
                        $current = $post->ID;
                        $parent = $post->post_parent;
                        $grandparent_get = get_post($parent);
                        $grandparent = $grandparent_get->post_parent;
                    ?>
                    <div class="page-title-group">
                        <h1 class="page-title wow animated fadeInUp"><?php the_title() ?></h1>
                    </div>
                </div>  
                <div class="page-multiple-cover-container">
                    <div class="row">
                        <?php  
                            $parent = new WP_Query( $args );
                            if ( $parent->have_posts() ) : ?>
                                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                    <div class="page-multiple-cover col-xs-4" style="background-image: url(<?php the_post_thumbnail_url('home-section') ?>)"></div>
                                <?php endwhile; ?>
                            <?php endif; wp_reset_query();
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="page-section parent-page-section">

            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-center">
                        <?php the_content()?>
                    </div>
                    <div class="col-lg-10 col-center">
                        <?php  
                            if ( $parent->have_posts() ) : ?>
                                <div class="children-pages-sidebar">
                                    <div class="row">
                                    <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                        <div class="col-sm-4">
                                            <a href="<?php the_permalink() ?>" class="child-page">
                                                <div class="img-responsive">
                                                    <?php the_post_thumbnail('home-section') ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php endif; wp_reset_query();
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <?php get_footer() ?>
