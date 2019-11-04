<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  LDWPD Custom Post
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear Database stored data
$portfolios = get_posts( array( 'post_type' => 'portfolio', 'numberposts' => -1 ) );

foreach( $portfolios as $portfolio ) {
	wp_delete_post( $portfolio->ID, true );
}

// Access the database via SQL
//global $wpdb;
//$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'portfolio'" );
//$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
//$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );