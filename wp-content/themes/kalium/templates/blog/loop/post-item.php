<?php
/**
 *	Blog post inside loop
 *	
 *	Laborator.co
 *	www.laborator.co 
 *
 *	@author		Laborator
 *	@var		@classes
 *	@version	2.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}
?>
<div class="container">xx</div>

<li <?php post_class( 'post' ); ?>>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		
		<?php
			/**
			 * kalium_blog_loop_post_before hook
			 *
			 * @hooked kalium_blog_post_thumbnail - 10
			 */
			do_action( 'kalium_blog_loop_post_before' );
		?>
		
		<div class="post-details">
			
			<?php
				/**
				 * kalium_blog_loop_post_details hook
				 *
				 * @hooked kalium_blog_post_title - 10
				 * @hooked kalium_blog_post_excerpt - 20
				 * @hooked kalium_blog_post_date - 30
				 * @hooked kalium_blog_post_category - 40
				 */
				do_action( 'kalium_blog_loop_post_details' );
			?>
            <div class="post-excerpt"> <?php the_field('excerpt') ?></div>
            
            <a class="btn" href="<?php the_permalink() ?>" role="button">Read more</a>
			
		</div>
		
		<?php
			/**
			 * kalium_blog_loop_post_after hook
			 *
			 * @hooked none
			 */
			do_action( 'kalium_blog_loop_post_after' );
		?>
		
	</div>
	
</li>