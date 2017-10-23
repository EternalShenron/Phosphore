<?php
/*
	Template Name: Page Enfant
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
                        
                        <div class="h3 wow animated fadeInDown" data-wow-duration="0.2s"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></div>
                        <?php 


                        // args
                        $sibling_pages = array(
                            'post_parent' => $post->post_parent,
                            'post_type' => 'page',
                            'post__not_in' => array($current)
                        );

                        // the query
                        $the_query = new WP_Query( $sibling_pages ); ?>
                        <?php $i = 1 ?>
                        <?php if ( $the_query->have_posts() ) : ?>
                            <!-- the loop -->
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <div class="h3 sibling-pages wow animated fadeInDown" data-wow-duration="0.3s" data-wow-delay="<?php echo $i * 0.12 . 's' ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
                                <?php $i = $i+1 ?>
                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </div>  
            </div>
        </div>
        
        <?php $i = 0 ?>
        <?php if( have_rows('sections') ): ?>
            <div class="sections">
            <?php while( have_rows('sections') ): the_row(); 
                $i = $i+1;
                if ($i % 2 == 0) {
                    $altern = 'even';
                } else {
                    $altern = 'odd';
                }
                $titre_section = get_sub_field('titre_section');
                $titre_navigation = get_sub_field('titre_navigation');
                $contenu_section = get_sub_field('contenu_section');
                $sections = get_field('sections');
                ?>
                <section id="section-<?php echo $i ?>" class="page-section section-<?php echo($altern) ?>">
                    <?php if ($altern == 'even'): ?>
                    <div class="page-section-bg" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post_id, 'large'); ?>)"></div>
                    <?php endif ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 wow animated fadeIn">
                                <h2 class="page-section-title wow animated fadeIn"><?php echo $titre_section; ?></h2>
                                <div class="section-content wow animated fadeIn"><?php echo $contenu_section; ?></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php $i = 0 ?>
        <?php if( have_rows('sections') ): ?>
            <nav id="toc">
                <ul class="nav nav-pills nav-stacked">
                <?php while( have_rows('sections') ): the_row(); ?>
                    <?php $i = $i+1; ?>
                    <?php $titre_navigation = get_sub_field('titre_navigation'); ?>
                    <li class="toc-item"><a href="#section-<?php echo $i ?>"><?php echo $titre_navigation ?></a></li>
                <?php endwhile; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>

    <?php get_footer() ?>
