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

                        <?php 


                        // args
                        $sibling_pages = array(
                            'post_parent' => $post->post_parent,
                            'post_type' => 'page',
                            'post__not_in' => array($current)
                        );

                        // the query
                        $the_query = new WP_Query( $sibling_pages ); ?>

                        <?php if ( $the_query->have_posts() ) : ?>

                            <!-- pagination here -->

                            <!-- the loop -->
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="h3 sibling-pages wow animated fadeInDown"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
                            <?php endwhile; ?>
                            <!-- end of the loop -->

                            <!-- pagination here -->

                            <?php wp_reset_postdata(); ?>

                        <?php else : ?>
                            <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
                        <?php endif; ?>


                    </div>
                </div>  
                <div class="page-multiple-cover-container">
                    <div class="row">
                        <?php  
                            $parent = new WP_Query( $args );
                            if ( $parent->have_posts() ) : ?>
                                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                    <div class="page-multiple-cover col-xs-4" style="background-image: url(<?php the_post_thumbnail_url() ?>)"></div>
                                <?php endwhile; ?>
                            <?php endif; wp_reset_query();
                        ?>
                    </div>
                </div>
            </div>

        </div>


<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <?php the_content()?>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>


        <?php get_footer() ?>
