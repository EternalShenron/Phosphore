<?php
/**
 *	Kalium WordPress Theme
 *
 *	Blog Core Functions
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Initialize blog options
 */
function kalium_blog_initialize_options( $extend_options = array(), $id = null ) {
	global $blog_options;
	
	// Single post page
	$is_single = is_single();
	
	// Blog template
	switch ( get_data( 'blog_template' ) ) {
		// Standard
		case 'blog-masonry' :
			$blog_template = 'standard';
			break;
		
		// Rounded
		case 'blog-rounded' :
			$blog_template = 'rounded';
			break;
		
		// Square is default
		default:
			$blog_template = 'square';
	}
	
	// Blog Options Array
	$options = array(
		// Blog instance id
		'id' => 'blog-posts-main',
		
		// Template to use (3 types)
		'blog_template' => $blog_template,
		
		// Loop blog options
		'loop' => array(
		
			// Blog header
			'header' => array(
				'show' => get_data( 'blog_show_header_title' ),
				'title' => get_data( 'blog_title' ),
				'description' => get_data( 'blog_description' ),
			),
			
			// Container classes
			'container_classes' => array( 'blog-posts' ),
			
			// Sidebar
			'sidebar' => array(
				
				// Visibility
				'visible' => 'hide' !== get_data( 'blog_sidebar_position' ),
				
				// Alignment
				'alignment' => get_data( 'blog_sidebar_position' ),
			),
			
			// Post formats support
			'post_formats' => get_data( 'blog_post_formats' ),
			
			// Post title
			'post_title' => get_data( 'blog_post_title', true ),
			
			// Post excerpt
			'post_excerpt' => get_data( 'blog_post_excerpt', true ),
			
			// Post date
			'post_date' => get_data( 'blog_post_date', true ),
			
			// Post category
			'post_category' => get_data( 'blog_category', true ),
			
			// Post thumbnail
			'post_thumbnail' => array(
				
				// Visibility
				'visible' => get_data( 'blog_thumbnails' ),
				
				// Image sizes
				'size' => 'thumbnail',
				
				// Hover layer
				'hover' => array(
					'type' => get_data( 'blog_thumbnail_hover_effect' ),
					'icon' => get_data( 'blog_post_hover_layer_icon' ),
					
					'custom' => array(
						'image_id' => get_data( 'blog_post_hover_layer_icon_custom' ),
						'width' => get_data( 'blog_post_hover_layer_icon_custom_width' )
					)
				),
			),
			
			// Post format icon
			'post_format_icon' => get_data( 'blog_post_type_icon' ),
			
			// Columns
			'columns' => 1,
			
			// Row layout mode
			'row_layout_mode' => get_data( 'blog_masonry_layout_mode' ),
				
			// Pagination
			'pagination' => array(
				'type' => get_data( 'blog_pagination_type' ),
				'alignment' => get_data( 'blog_pagination_position' ),
				'style' => '_2' == get_data( 'blog_endless_pagination_style' ) ? 'pulsating' : 'spinner',
			),
		),
		
		// Single blog options
		'single' => array(
			
			// Share story
			'share' => array(
				
				// Visibility
				'visible' => get_data( 'blog_share_story' ),
				
				// Share networks
				'networks' => get_data( 'blog_share_story_networks' ),
				
				// Icons style
				'style' => get_data( 'blog_share_story_rounded_icons' ) ? 'icons' : 'plain',
			),
			
			// Sidebar
			'sidebar' => array(
				
				// Visibility
				'visible' => 'hide' !== get_data( 'blog_single_sidebar_position' ),
				
				// Alignment
				'alignment' => get_data( 'blog_single_sidebar_position' ),
			),
			
			// Post image
			'post_image' => array(
				
				// Visibility
				'visible' => get_data( 'blog_single_thumbnails' ),
				
				// Image size
				'size' => 'default' == get_data( 'blog_featured_image_size_type' ) ? 'blog-single-1' : 'original',
				
				// Image placement
				'placement' => 'full-width' == get_data( 'blog_featured_image_placement' ) ? 'full-width' : 'boxed',
			),
			
			// Post title
			'post_title' => get_data( 'blog_single_title', true ),
			
			// Post tags
			'post_tags' => get_data( 'blog_tags' ),
			
			// Post category
			'post_category' => get_data( 'blog_category_single', true ),
			
			// Post date
			'post_date' => get_data( 'blog_post_date_single', true ),
			
			// Post comments
			'post_comments' => 'hide' != get_data( 'blog_comments' ),
			
			// Author
			'author' => array(
				
				// Visibility
				'visible' => get_data( 'blog_author_info' ),
				
				// Author info placement
				'placement' => get_data( 'blog_author_info_placement', 'left' )
			),
			
			// Prev next navigation
			'prev_next' => get_data( 'blog_post_prev_next' ),
			
			// Gallery carousel auto switch
			'gallery_autoswitch_image' => absint( get_data( 'blog_gallery_autoswitch' ) )
		)
	);
	
	// Blog instance ID
	if ( $id ) {
		$options['id'] = sprintf( 'blog-posts-%s', esc_attr( $id ) );
	}
	
	// Blog settings based on blog template
	switch ( $blog_template ) {
		
		// Square post thumbnail
		case 'square' :
			$options['loop']['post_thumbnail']['size'] = 'blog-thumb-1';
			break;
		
		// Rounded post thumbnail
		case 'rounded' :
			$options['loop']['post_thumbnail']['size'] = 'blog-thumb-2';
			break;
		
		// Standard post item
		case 'standard' : 
			$options['loop']['post_thumbnail']['size'] = 'blog-thumb-3';
			
			// Standard blog columns
			$options['loop']['columns'] = absint( ltrim( get_data( 'blog_columns' ), '_' ) );
			break;
	}
	
	// Proportional thumbnails
	if ( get_data( 'blog_loop_proportional_thumbnails' ) && 'rounded' !== $blog_template ) {
		$options['loop']['post_thumbnail']['size'] = 'large';
	}
	
	// Rounded blog template does not supports post formats on loop
	if ( ! $is_single && 'rounded' == $blog_template ) {
		$options['loop']['post_formats'] = false;
	}
		
	// Loop Standard Post Template
	if ( 'standard' == $blog_template && ! $is_single ) {
		$options['loop']['container_classes'][] = sprintf( 'columns-%d', $options['loop']['columns'] );
	}
	
	// When its assigned as blog page
	if ( is_home() && ( $post = get_queried_object() ) ) {
		$heading_title = get_field( 'heading_title', $post->ID );
		
		// Show heading title
		if ( $heading_title ) {
			$heading_title_type = get_field( 'page_heading_title_type', $post->ID );
			$heading_custom_title = get_field( 'page_heading_custom_title', $post->ID );
			$heading_description_type = get_field( 'page_heading_description_type', $post->ID );
			$heading_custom_description = get_field( 'page_heading_custom_description', $post->ID );
			
			$options['loop']['header']['show'] = true;
			$options['loop']['header']['title'] = 'post_title' == $heading_title_type ? get_the_title( $post ) : $heading_custom_title;
			$options['loop']['header']['description'] = 'post_content' == $heading_description_type ? apply_filters( 'the_content', $post->post_content ) : $heading_custom_description;
		}
	}
	
	// Single
	if ( is_single() ) {
		$post_id = get_queried_object_id();
		
		// Featured image placement
		$featured_image_placement = get_field( 'featured_image_placing', $post_id );
		
		if ( $featured_image_placement && in_array( $featured_image_placement, array( 'container', 'full-width', 'hide' ) ) ) {
			$options['single']['post_image']['placement'] = 'full-width' == $featured_image_placement ? 'full-width' : 'boxed';
			
			if ( 'hide' == $featured_image_placement ) {
				$options['single']['post_image']['visible'] = false;
			}
		}
		
		// Featured image size
		$post_image_size = get_field( 'post_image_size', $post_id );
		
		if ( in_array( $post_image_size, array( 'default', 'full' ) ) ) {
			$options['single']['post_image']['size'] = 'default' == $post_image_size ? 'blog-single-1' : 'original';
		}
		
		// When sidebar is present and author info is shown horizontally
		if ( $options['single']['author']['visible'] && $options['single']['sidebar']['visible'] && in_array( $options['single']['sidebar']['alignment'], array( 'left', 'right' ) ) ) {
			//$options['single']['author']['placement'] = 'bottom';
		}
		
		// Password protected post
		if ( post_password_required() ) {
			$options['single']['post_image']['visible'] = false;
			$options['single']['author']['visible'] = false;
			$options['single']['share']['visible'] = false;
			$options['single']['post_tags'] = false;
			$options['single']['prev_next'] = false;
		} 
		// Attachment
		else if ( is_attachment() ) {
			$options['single']['author']['visible'] = false;
			$options['single']['share']['visible'] = false;
			$options['single']['post_tags'] = false;
			$options['single']['prev_next'] = false;
		}
	}
	
	// Extend/replace blog options
	if ( ! empty( $extend_options ) && is_array( $extend_options ) ) {
		// Remove ID
		if ( isset( $extend_options['id'] ) ) {
			unset( $extend_options['id'] );
		}
		
		$options = array_merge( $extend_options );
	}
	
	// Blog options
	$blog_options = apply_filters( 'kalium_blog_options', $options );

	return $blog_options;
}

/**
 * Get blog option value
 */
function kalium_blog_get_option( $option_name ) {
	global $blog_options;
	
	// If blog options are not initalized
	if ( empty( $blog_options ) ) {
		kalium_blog_initialize_options();
	}
	
	// Get option
	$option_path = explode( '/', $option_name );
	
	$option_value = null;
	
	while ( $key = array_shift( $option_path ) ) {
		
		if ( is_null( $option_value ) && isset( $blog_options[ $key ] ) ) {
			$option_value = $blog_options[ $key ];
		} elseif ( isset( $option_value[ $key ] ) ) {
			$option_value = $option_value[ $key ];
		} else {
			return new WP_Error( 'kalium_blog_error', sprintf( "Blog option <strong>%s</strong> doesn't exists!", $option_name ) );
		}
	}
	
	return $option_value;
}

/**
 * Get current instance ID of blog
 */
function kalium_blog_instance_id() {
	return kalium_blog_get_option( 'id' );
}

/**
 * Check if its inside Kalium blog loop
 */
function kalium_blog_is_in_the_loop() {
	global $blog_options;
	
	return in_the_loop() && ! is_single() && ! empty( $blog_options );
}

/**
 * Reset blog options global
 */
function kalium_blog_reset_options() {
	global $blog_options;
	
	$blog_options = array();
}

/**
 * External Post Redirect
 */
function kalium_blog_external_post_format_redirect() {
	
	if ( is_single() && 'link' == get_post_format() && apply_filters( 'kalium_blog_external_link_redirect', true ) ) {
		$urls = wp_extract_urls( get_the_content() );
		
		if ( $urls ) {
			wp_redirect( current( $urls ) );
			exit;
		}
	}
}

/**
 * Extract post format content
 */
function kalium_extract_post_format_content( $post = null ) {
	global $wp_embed;
	
	$result = null;
	
	if ( ! $post ) {
		$post = get_post();
	}
	
	if ( is_a( $post, 'WP_Post' ) ) {	
		$post_content_plain = $post->post_content;
		$the_content = apply_filters( 'the_content', $post_content_plain );
		
		$post_content = array_filter( explode( PHP_EOL, $the_content ) );
		$post_content = strip_tags( $post_content[0], '<p><a><img>' );
		
		// Thumbnail size to use
		if ( is_single() ) {
			$thumbnail_size = kalium_blog_get_option( 'single/post_image/size' );
		} else {
			$thumbnail_size = kalium_blog_get_option( 'loop/post_thumbnail/size' );
		}
		
		// Extract post format
		$post_format = get_post_format( $post );
		
		switch ( $post_format ) {
			
			// Image post format
			case 'image':
			
				// Find image within tag
				if ( preg_match( "/(<a.*?href=(\"|')(?<href>.*?)(\"|').*?>)?<img.*?\s+src=(\"|')(?<image>.*?)(\"|').*?>(<\/a>)?/", $post_content_plain, $matches ) ) {
					$href = $matches['href'];
					$image_url = $matches['image'];
					
					// Use href if its image type
					if ( $href && preg_match( '/\.(png|jpe?g|gif)$/i', $href ) ) {
						$image_url = $href;
					}
					
					$result = array(
						'type' => $post_format,
						'content' => $matches[0],
						'media' => $image_url
					);
				}
				// Find image url
				else if ( filter_var( strip_tags( $post_content ), FILTER_VALIDATE_URL ) ) {
					$result = array(
						'type' => $post_format,
						'content' => $post_content,
						'media' => strip_tags( $post_content )
					);
				}
				break;
			
			// Gallery post format
			case 'gallery' :
				$gallery_images = get_field( 'post_slider_images', $post->ID );
				
				// Only when has gallery items
				if ( ! empty( $gallery_images ) ) {
					$gallery_html = '';
					
					foreach ( $gallery_images as $gallery_image ) {
						if ( ! empty( $gallery_image['id'] ) ) {
							$image = kalium_get_image_placeholder( $gallery_image['id'], $thumbnail_size );
							$image_link = is_single() ? kalium_blog_post_image_link( get_post( $gallery_image['id'] ) ) : get_permalink( $post );
							
							$gallery_html .= sprintf( '<li><a href="%s">%s</a></li>', $image_link, $image );
						}
					}
					
					// Gallery has items
					if ( $gallery_html ) {
						$gallery_autoswitch_image = kalium_blog_get_option( 'single/gallery_autoswitch_image' );
						
						if ( is_single() && $gallery_autoswitch_image > 0 ) {
							$gallery_html = sprintf( '<ul class="%s" data-autoswitch="%d">%s</ul>', 'post-gallery-images', $gallery_autoswitch_image, $gallery_html );
						} else {
							$gallery_html = sprintf( '<ul class="%s">%s</ul>', 'post-gallery-images', $gallery_html );
						}
						
						$result = array(
							'type' => $post_format,
							'content' => '',
							'media' => $gallery_html
						);
					}
				}
				break;
			
			// Video + Audio
			case 'video' :
			case 'audio' :
			
				$urls = wp_extract_urls( $post_content_plain );
				$is_audio = 'audio' == $post_format;

				// Has URLs
				if ( ! empty( $urls ) ) {
					$url = reset( $urls );
					$autoplay = is_single() ? get_field( 'auto_play_video', $post->ID ) : false;
					
					// Set autoplay
					if ( $autoplay ) {
						if ( $is_audio ) {
							add_filter( 'kalium_audio_shortcode_container_atts', 'kalium_videojs_set_auto_play', 10 );
						} else {
							add_filter( 'kalium_video_shortcode_container_atts', 'kalium_videojs_set_auto_play', 10 );
						}
					}
					
					// Set aspect ratio
					if ( ! $is_audio && ( $video_resolution = get_field( 'video_resolution', $post->ID ) ) ) {
						$video_resolution_fn = create_function( '$attrs', sprintf( 'return array_merge( $attrs, kalium_extract_aspect_ratio( "%s" ) );', esc_attr( $video_resolution ) ) );

						add_filter( 'kalium_video_atts', $video_resolution_fn, 10 );
					}
					
					$media = $wp_embed->autoembed( $url );
					
					// Check for video shortcode
					if ( preg_match( "/\[(video|audio) [^\]]+\]/", $media ) ) {
						$media = do_shortcode( $media );
					}
					
					// Remove autoplay
					if ( $autoplay ) {
						if ( $is_audio ) {
							remove_filter( 'kalium_audio_shortcode_container_atts', 'kalium_videojs_set_auto_play', 10 );
						} else {
							remove_filter( 'kalium_video_shortcode_container_atts', 'kalium_videojs_set_auto_play', 10 );
						}
					}
					
					// Remove aspect ratio
					if ( isset( $video_resolution_fn ) ) {
						remove_filter( 'kalium_video_atts', $video_resolution_fn, 10 );
					}
					
					$result = array(
						'type' => $post_format,
						'content' => $media,
						'media' => $media
					);
				}
				break;
			
			// Quotes
			case 'quote' :
			
				if ( preg_match( "/^\s*<blockquote.*?>(?<quote>.*?)(?<cite><cite>(?<author>.*?)<\/cite>)?<\/blockquote>/s", $post_content_plain, $matches ) ) {
					$content   = $matches[0];
					$quote     = $matches['quote'];
					$author    = get_array_key( $matches, 'author' );
					
					
					$result = array(
						'type'    => $post_format,
						'content' => $content,
						'quote'   => $quote,
						'author'  => $author
					);
				}
				
				break;
		}
		
		// Generate media
		if ( is_array( $result ) ) {
			
			// Generate image placeholder
			if ( 'image' == $result['type'] ) {
				$result['generated'] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $post ) ), kalium_get_image_placeholder( $result['media'] ) );
			}
		}
	}
	
	return $result;
}

/**
 * Show post content format media
 */
function kalium_show_post_format_content( $result, $return = false ) {
	$html = '';
	
	// Check if its valid result from extracted post format content
	if ( is_array( $result ) && isset( $result['type'] ) ) {
		
		switch ( $result['type'] ) {
			// Image
			case 'image' : 
				$html = $result['generated'];
				break;
			
			// Gallery
			case 'gallery' :
				$html = $result['media'];
				
				// This requires slick slider gallery
				kalium_enqueue_slick_slider_library();
				break;
				
			// Video + audio
			case 'video' :
			case 'audio' :
				$html = $result['media'];
				break;
			
			
			// Quote
			case 'quote' :
				$quote = $result['quote'];
				$author = $result['author'];
				
				if ( $author ) {
					$quote .= "<cite>{$author}</cite>";
				}
				
				$html = sprintf( '<div class="post-quote"><blockquote>%s</blockquote></div>', $quote );
				
				break;
		}
		
	}
	
	if ( $return ) {
		return $html;
	}
	
	echo $html;
}

/**
 * Blog post content, clear post format if its enabled to be parsed
 */
function kalium_blog_clear_post_format_from_the_content( $content ) {
	global $post, $wp_embed;
	
	// Image post
	if ( has_post_format( 'image' ) ) {
		$post_format = kalium_extract_post_format_content( $post );
		
		if ( ! empty( $post_format['content'] ) ) {
			$post_format_content = strip_tags( $post_format['content'], '<img>' );
			$content = preg_replace( sprintf( '/%s/', preg_quote( $post_format_content, '/' ) ), '', $content );
		}
	}
	// Quote post
	else if ( has_post_format( 'quote' ) ) {
		
		$post_format = kalium_extract_post_format_content( $post );
		
		if ( ! empty( $post_format['content'] ) ) {
			$post_format_content = $post_format['content'];
			$content = preg_replace( sprintf( '/%s/', preg_quote( $post_format_content, '/' ) ), '', $content );
		}
	}
	// Audio post
	else if ( has_post_format( 'audio' ) ) {
		$content = preg_replace( '/\[audio.*?\](\[\\/audio\])?/', '', $content );
	}
	// Video post
	else if ( has_post_format( 'video' ) ) {
		
		$urls = wp_extract_urls( $content );
		
		if ( ! empty( $urls ) ) {
			$url = reset( $urls );
			$has_media = $url !== $wp_embed->autoembed( $url );
			
			$video_shortcode_regex = '/\[video.*?\](\[\\/video\])?/';
			
			// Remove first video shortcode
			if ( preg_match( $video_shortcode_regex, $content ) ) {
				$content = preg_replace( $video_shortcode_regex, '', $content );
			}
			// Replace known embeds
			else if ( $has_media ) {
				$content = preg_replace( sprintf( '/%s/', preg_quote( $url, '/' ) ), '', $content );
			} 
		}
	}
	
	return $content;
}

/**
 * Use featured image of post for video items
 */
function kalium_blog_post_video_poster_replace( $atts, $post_id ) {
	$post = get_post( $post_id );
	
	if ( ! is_null( $post ) && 'post' == $post->post_type && has_post_thumbnail( $post ) ) {
		if ( is_single() ) {
			$thumbnail_size = kalium_blog_get_option( 'single/post_image/size' );
		} else {
			$thumbnail_size = kalium_blog_get_option( 'loop/post_thumbnail/size' );
		}
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), $thumbnail_size );
		
		if ( ! is_wp_error( $image ) ) {
			$atts['poster'] = $image[0];
		}
	}
	
	return $atts;
}

/**
 * Change "href" for link post formats
 */
function kalium_blog_post_format_link_url( $permalink, $post ) {
	
	if ( 'link' == get_post_format( $post ) ) {
		$post_links = wp_extract_urls( apply_filters( 'the_content', $post->post_content ) );
		
		if ( ! empty( $post_links ) ) {
			return reset( $post_links );
		}
	}
	
	return $permalink;
}

/**
 * Get post featured image link or return post image link instead
 */
function kalium_blog_post_image_link( $post ) {
	
	if ( has_post_thumbnail( $post ) ) {
		return get_the_post_thumbnail_url( $post, 'original' );
	} else if ( is_object( $post ) && 'attachment' == $post->post_type ) {
		return $post->guid;
	}
	
	return get_permalink( $post );
}

/**
 * Single post comments visibility
 */
function kalium_blog_comments_visibility( $visible ) {
	
	return kalium_blog_get_option( 'single/post_comments' );
}