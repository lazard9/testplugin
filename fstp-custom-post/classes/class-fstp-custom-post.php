<?php

/*
 * Custom Post Type, single post page template and ULR structure
 */

namespace FSTP\Classes;

class FSTP_Custom_Post
{
	public function register_post() {
		add_action( 'init', array( $this, 'fstp_custom_post_type' ) );
		add_filter( 'single_template', array( $this, 'load_estates_template' ) );
		add_filter( 'rewrite_rules_array', array( $this, 'so23698827_add_rewrite_rules' ) );
		add_filter( 'post_type_link', array( $this, 'so23698827_filter_post_type_link' ), 10, 2 );
	}

	/*
	 * Custom Post Type
	 */
	public function fstp_custom_post_type () {
		
		$labels = array(
			'name' => 'Real Estate',
			'singular_name' => 'Real Estate',
			'add_new' => 'Add Estate',
			'all_items' => 'All Estates',
			'add_new_item' => 'Add Estate',
			'edit_item' => 'Edit Estate',
			'new_item' => 'New Estate',
			'view_item' => 'View Estate',
			'search_item' => 'Search Real Estate',
			'not_found' => 'No items found',
			'not_found_in_trash' => 'No items found in trash',
			'parent_item_colon' => 'Parent Estate'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_icon' => 'dashicons-admin-multisite',
			'supports' => array(
				'title',
				//'editor',
				//'excerpt',
				'thumbnail',
				//'revisions',
				//'comments',
				'author',
			),
			'rewrite' => array(
			    'slug' => 'estates/%type%',
			    'with_front' => true
			),
			//'taxonomies' => array('category', 'post_tag'),
			'menu_position' => 5,
			'exclude_from_search' => false
		);
		register_post_type('estates',$args);
	}

	/*
     * Single estates template is not found on theme or child theme directories, load it from plugin directory
     */
	function load_estates_template( $template ) {
	    global $post;

    	if ( 'estates' === $post->post_type && locate_template( array( 'single-estates.php' ) ) !== $template ) {
	        
	        return FSTP_PLUGIN_PATH . 'templates/single-estates.php';
	        
	        $this->custom_taxonomy_terms(); 
	    }

	    return $template;
	}

	/*
	 * Custom Term Function
	 */
	function custom_taxonomy_terms( $postID, $term ) {
	
		$terms_list = get_the_terms($postID, $term); 
		$output = array();

		if ( ! empty( $terms_list ) ) {
		    foreach ( $terms_list as $term ) {
		        $output[] = sprintf( '<a href="%1$s">%2$s</a>',
		            esc_url( get_term_link( $term ) ),
		            esc_html( $term->name )
		        );
			}
		}

	    return implode( ', ', $output );
	}

	/*
	 * Tell WordPress how to interpret our project URL structure
	 *
	 * @param array $rules Existing rewrite rules
	 * @return array
	 * @source {https://wordpress.stackexchange.com/questions/39500/how-to-create-a-permalink-structure-with-custom-taxonomies-and-custom-post-types/39862#39862}
	 * @source {https://stackoverflow.com/questions/23698827/custom-permalink-structure-custom-post-type-custom-taxonomy-post-name}
	 */
	function so23698827_add_rewrite_rules( $rules ) {
	  $new = array();
	  $new['estates/([^/]+)/(.+)/?$'] = 'index.php?estates=$matches[2]';
	  $new['estates/(.+)/?$'] = 'index.php?type=$matches[1]';

	  return array_merge( $new, $rules ); // Ensure our rules come first
	}

	/*
	 * Handle the '%project_category%' URL placeholder
	 *
	 * @param str $link The link to the post
	 * @param WP_Post object $post The post object
	 * @return str
	 */
	function so23698827_filter_post_type_link( $link, $post ) {
	  if ( $post->post_type == 'estates' ) {
	    if ( $cats = get_the_terms( $post->ID, 'type' ) ) {
	      $link = str_replace( '%type%', current( $cats )->slug, $link );
	    }
	  }
	  return $link;
	}
} 