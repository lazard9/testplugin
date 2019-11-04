<?php

class FSTP_Taxonomies
{
	public function register_taxonomies() {
		add_action( 'init', array( $this, 'fstp_custom_taxonomies' ) );
		add_action( 'save_post', array( $this, 'mfields_set_default_object_terms'), 100, 2 );
		add_action( 'add_meta_boxes', array( $this, 'add_location_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_location_taxonomy' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_type_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_type_taxonomy' ) );
	}

	public function fstp_custom_taxonomies() {
		//add new taxonomy Location not hierarchical
		register_taxonomy( 'location', 'estates', array(
			'labels' => array(
				'name' => 'Location',
				'singular_name' => 'Location',
				'search_items' => 'Search Locations',
				'all_items' => 'All Locations',
				'parent_item' => 'Parent Location',
				'parent_item_colon' => 'Parent Field:',
				'edit_item' => 'Edit Location',
				'update_item' => 'Update Location',
				'add_new_item' => 'Add New Location',
				'new_item_name' => 'New Location Name',
				'menu_name' => 'Location'
			),
			'show_in_quick_edit' => false,
			'meta_box_cb' => false,
			'hierarchical' => false
		));
		
		//add new taxonomy Type not hierarchical
		register_taxonomy( 'type', 'estates', array(
			'labels' => array(
				'name' => 'Type',
				'singular_name' => 'Type',
				'search_items' => 'Search Types',
				'all_items' => 'All Types',
				'parent_item' => 'Parent Type',
				'parent_item_colon' => 'Parent Field:',
				'edit_item' => 'Edit Type',
				'update_item' => 'Update Type',
				'add_new_item' => 'Add New Type',
				'new_item_name' => 'New Type Name',
				'menu_name' => 'Type'
			),
			'show_in_quick_edit' => false,
			'meta_box_cb' => false,
			'hierarchical' => false,
			'rewrite' => array(
				'slug' => 'estates',
				'with_front' => true
			)
		));
	}

	/*
	 * Set default cat for cpt
	 * @source {https://circlecube.com/says/2013/01/set-default-terms-for-your-custom-taxonomy-default/}
	 * @source {http://wordpress.mfields.org/2010/set-default-terms-for-your-custom-taxonomies-in-wordpress-3-0/}
	 * @license   GPLv2
	 */
	function mfields_set_default_object_terms( $post_id, $post ) {
		if ( 'publish' === $post->post_status && $post->post_type === 'estates' ) {
			$defaults = array(
				'location' => array( 'Any' ),
				'type' => array( 'None' )
			);
			$taxonomies = get_object_taxonomies( $post->post_type );

			foreach ( (array) $taxonomies as $taxonomy ) {
				$terms = wp_get_post_terms( $post_id, $taxonomy );
				if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
					wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
				}
			}
		}
	}

	function add_location_meta_box(){
		add_meta_box(
			'location_box',
			__('Location'),
			array( $this, 'location_meta_box_term'),
			'estates',
			'side',
		);
	}

	function location_meta_box_term( $post ) {
		$terms = get_terms( array(
			'taxonomy' => 'location',
			'hide_empty' => false // Retrieve all terms
		));

		// We assume that there is a single category
		$currentTaxonomyValue = get_the_terms($post->ID, 'location')[0];
	?>
		<p>Choose taxonomy value</p>
		<p>
			<?php foreach($terms as $term): ?>
				<input type="radio" name="location" id="taxonomy_term_<?php echo $term->term_id;?>" value="<?php echo $term->term_id;?>"<?php if($term->term_id==$currentTaxonomyValue->term_id) echo "checked"; ?>>
				<label for="taxonomy_term_<?php echo $term->term_id;?>"><?php echo $term->name; ?></label>
				</input><br/>
			<?php endforeach; ?>
		</p>
	<?php
	}

	function save_location_taxonomy($post_id){
		if ( isset( $_REQUEST['location'] ) ) 
			wp_set_object_terms($post_id, (int)sanitize_text_field( $_POST['location'] ), 'location');
	}

	function add_type_meta_box(){
		add_meta_box(
			'type_box',
			__('Type'),
			array( $this, 'type_meta_box_term'),
			'estates',
			'side',
		);
	}

	function type_meta_box_term( $post ) {
		$terms = get_terms( array(
			'taxonomy' => 'type',
			'hide_empty' => false // Retrieve all terms
		));

		// We assume that there is a single category
		$currentTaxonomyValue = get_the_terms($post->ID, 'type')[0];
	?>
		<p>Choose taxonomy value</p>
		<p>
			<?php foreach($terms as $term): ?>
				<input type="radio" name="type" id="taxonomy_term_<?php echo $term->term_id;?>" value="<?php echo $term->term_id;?>"<?php if($term->term_id==$currentTaxonomyValue->term_id) echo "checked"; ?>>
				<label for="taxonomy_term_<?php echo $term->term_id;?>"><?php echo $term->name; ?></label>
				</input><br/>
			<?php endforeach; ?>
		</p>
	<?php
	}

	function save_type_taxonomy($post_id){
		if ( isset( $_REQUEST['type'] ) ) 
			wp_set_object_terms($post_id, (int)sanitize_text_field( $_POST['type'] ), 'type');
	}
} 