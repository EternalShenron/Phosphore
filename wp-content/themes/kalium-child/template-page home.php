<?php
/*
	Template Name: Page Home
*/
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


get_header();

// the_content();
/*note small device, les images doivent disparaitre sauf le slider*/
?>

            <?php 
            // args
            $slider_posts = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'menu_order'
            );
            // the query
            $home_slider_query = new WP_Query( $slider_posts ); ?>

            <?php if ( $home_slider_query->have_posts() ) : ?>
            <section id="home-slider-section">

                <div  class="home-posts-slider owl-carousel owl-theme wow animated fadeIn">
                    <!-- the loop -->
                    <?php while ( $home_slider_query->have_posts() ) : $home_slider_query->the_post(); ?>

                        <!-- Vars -->
                        <?php 
                        $excerpt = get_field('excerpt') 
                        ?>

                        <div class="slide" style="background-image: url(<?php the_post_thumbnail_url('full') ?>)">
                            <div class="container">
                                <div class="slide-content">
                                    <div class="post-info">
                                        <h2 class="post-title"><?php the_title(); ?></h2>
                                        <div class="post-excerpt-container">
                                            <div class="post-excerpt">
                                                <?php if ($excerpt): ?>
                                                    <?php echo $excerpt ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <a href="<?php the_permalink() ?>" class="btn">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php endwhile; ?>
                    <!-- end of the loop -->
                    <?php wp_reset_postdata(); ?>
                </div>
                    <div class="slide-progress"></div>
            </section>
            <?php endif; ?>
            

        <section class="text-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="homepage-byline h4">
                        <?php if (get_field('punchline')): ?>
                            <?php the_field('punchline') ?>
                        <?php endif ?> 
                    </div>
                </div>
            </div>
        </section>

        
    
    <?php $i = 0 ?>
    <?php if( have_rows('section_de_home') ): ?>
        <section class="zigzag-sections">
        <?php while( have_rows('section_de_home') ): the_row(); 
            $i = $i+1;
            if ($i % 2 == 0) {
                $altern = 'even';
            } else {
                $altern = 'odd';
            }
            $titre_section_home = get_sub_field('titre');
            $resume = get_sub_field('resume');
            $image = get_sub_field('image')['sizes']['medium_large'];
            $page_en_lien = get_sub_field('page_en_lien');
            $id_page_en_lien = get_sub_field('page_en_lien')->ID;
            $libelle_bouton = get_sub_field('libelle_bouton');
            ?>

            <div id="home-subsection-<?php echo $i ?>" class="home-subsection subsection-<?php echo($altern) ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 subsection-image-column">
                            <div class="subsection-image" <?php if ($image) { echo 'style=background-image:url("' . $image . '")'; } ; ?>></div>
                        </div>
                        <div class="col-sm-6 subsection-content-column">
                            <div class="subsection-content">
                                <div class="subsection-title">
                                    <h2><?php echo $titre_section_home; ?></h2>
                                </div>
                                <div class="subsection-resume">
                                    <?php echo $resume; ?>
                                </div>
                                <a href="<?php echo the_permalink($id_page_en_lien) ?>" class="btn"><?php if ($libelle_bouton) { echo $libelle_bouton; } else { echo 'Learn more'; } ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </section>
    <?php endif; ?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">la section exemples</div>
            <div class="row" style="padding:5em">
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
            </div>
            <div class="col-lg-12 hidden-xs hidden-sm">la sous section exemple</div>
            <div class="row hidden-xs hidden-sm" style="padding:5em">
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
            </div>
        </div>
    </div>

    <?php get_footer() ?>
