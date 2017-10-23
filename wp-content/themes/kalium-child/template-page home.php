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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <?php putRevSlider("homeslider", "homepage") ?>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 hidden-xs hidden-sm" style="background-image:url('http://localhost/Sites%20WEB/rams/wordpress/wp-content/uploads/2017/10/Openpit-e1508327885652.jpg'); height:10em">la punchline grand
                <?php if (get_field('punchline')): ?>
                <?php the_field('punchline') ?>
                <?php endif ?> </div>
            <div class="col-xs-12 hidden-md hidden-lg">la punchline petite
                <?php if (get_field('punchline')): ?>
                <?php the_field('punchline') ?>
                <?php endif ?>
            </div>
        </div>
    </div>

        
    
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
            $id = get_field('lien_vers_article');
            ?>
            <div id="home-subsection-<?php echo $i ?>" class="home-subsection subsection-<?php echo($altern) ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 subsection-image-column">
                            <div class="subsection-image" <?php if ($image) { echo 'style=background-image:url("' . $image . '")'; } ; ?>></div>
                        </div>
                        <div class="col-sm-6 subsection-content-column">
                            <div class="subsection-title">
                                <h3><?php echo $titre_section_home; ?></h3>
                            </div>
                            <div class="subsection-content">
                                <?php echo $resume; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </section>
    <?php endif; ?>



        <div class="row" style="height:10em">
            <div class="col-md-6 hidden-xs hidden-sm">image</div>
            <div class="col-xs-12 col-md-6">
                <?php echo get_the_title( 29 ); ?>
                <?php the_field (resume_industries, 29); ?>
            </div>
        </div>
        <div class="row" style="height:10em">
            <div class="col-md-6">
                <?php echo get_the_title( 31 ); ?>
                <?php the_field (resume_capabilities, 31); ?>
            </div>
            <div class="col-md-6 hidden-xs hidden-sm">image</div>
        </div>
        <div class="row" style="height:10em">
            <div class="col-md-6 hidden-xs hidden-sm">Image</div>
            <div class="col-md-6">
                <?php echo get_the_title( 21 ); ?> 
            <?php the_field (resume_career, 21); ?>
            </div>
        </div>


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
