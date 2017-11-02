<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

get_header();

/**
 * Show post information if exists
 */
if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		if (get_post()->post_type != 'post') {
			# code...
				/**
				 * kalium_blog_single_before_content
				 *
				 * @hooked kalium_blog_single_post_image_full_width - 10
				 **/
				do_action( 'kalium_blog_single_before_content' );
				
					?>
					<div <?php kalium_blog_single_container_class(); ?>>
						
						<div class="container">
						
							<div class="row">
								
								<?php
									/**
									 * kalium_blog_single_content hook
									 *
									 * @hooked kalium_blog_single_post_image_boxed - 10
									 * @hooked kalium_blog_single_post_layout - 20
									 * @hooked kalium_blog_single_post_sidebar - 30
									 **/
									do_action( 'kalium_blog_single_content' );
								?>
								
							</div>
						
						</div>
						
					</div>
					<?php
				
				/**
				 * kalium_blog_single_after_content
				 *
				 * @hooked kalium_blog_single_post_comments - 10
				 **/
				do_action( 'kalium_blog_single_after_content' );
		} else {
			?>

			<div class="post-cover wow animated fadeIn" style="background-image: url(<?php echo get_the_post_thumbnail_url( 19, 'large'); ?>)">

				<div class="container">
					<div class="h4 post-subtitle wow animted fadeIn"><?php the_field('subtitle') ?></div>
					<div class="post-header">
						<div class="row">
							<div class="col-xs-12 col-md-4">
								<div class="post-image wow animated fadeInUp" data-wow-duration="0.9s" data-wow-delay="-0.3s"><?php the_post_thumbnail('post-thumb') ?></div>
							</div>
							<div class="col-xs-12 col-md-5">
								<div class="post-info">
								<h1 class="post-title wow animated fadeIn" data-wow-delay="0.2s"><?php the_title() ?></h1>
									<div class="post-excerpt wow animated fadeInRight" data-wow-duration="0.9s" data-wow-delay="-0.35s">
                                                <div class="post-excerpt-container padded-multiline">
                                                    <div class="post-excerpt highlighted">
                                                        <span><?php the_field('excerpt') ?></span>
                                                    </div>
                                                </div>
									</div>
									<div class="post-meta-group">
										<div class="wow animated fadeInRight" data-wow-duration="0.9s" data-wow-delay="-0.3s"><?php kalium_blog_post_date() ?></div>
										<div class=" wow animated fadeInRight" data-wow-duration="0.9s" data-wow-delay="-0.25s"><?php kalium_blog_post_category() ?></div>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>



			<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
				<div class="container">

					<div class="row">

						<div class="col-xs-12 col-md-8">
							<div class="post-content">
								<?php the_content() ?>
							</div>
						</div>
						<div class="col-xs-12 col-md-3 col-md-push-1">
							<div class="post-sidebar">
								<h3>Read full article</h3>
								<?php 
								$file = get_field('fichier_a_telecharger');
								if ($file): ?>
								<aside class="widget">
									<a href="<?php echo $file['url'] ?>" download="<?php the_title() ?>" class="btn btn-primary download pdf">Download</a>
								</aside>
								<?php endif	; ?>
								<?php if (get_field('commentaires')): ?>
								<aside class="widget">
									<h3>Comment</h3>
									<div class="post-comment"><?php the_field('commentaires') ?></div>
								</aside>
								<?php endif ?>
								<aside class="widget">
									<a href="#" class="btn btn-primary">Contact us</a>
								</aside>
							</div>
						</div>
					</div>
				</div>
			</article>				

			<?php 		
			}		
	endwhile;
		
endif;


get_footer();