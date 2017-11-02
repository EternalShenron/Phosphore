<?php
/**
 *	Page heading title and description
 *	
 *	Laborator.co
 *	www.laborator.co 
 *
 *	@author		Laborator
 *	@var		$heading_tag
 *	@var		$title
 *	@var		$description
 *	@version	2.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}
?>
<section>

        <div id="page-cover-maintainer">
            <div class="page-cover wow animated fadeIn" style="background-image: url(<?php echo get_the_post_thumbnail_url( 19, 'large'); ?>)">
                <div class="container">
                    <?php 
                        $current = $post->ID;
                        $parent = $post->post_parent;
                        $grandparent_get = get_post($parent);
                        $grandparent = $grandparent_get->post_parent;
                    ?>
                    <div class="page-title-group">
                        <h1 class="page-title wow animated fadeInUp"><?php echo get_the_title(19) ?></h1>
                    </div>
                    <p class="subtitle">An open-pit to our deep experience</p>
                </div>  
            </div>
        </div>


	
</section>