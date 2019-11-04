<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

?>

<div class="wrapper" id="single-wrapper">

	<div style="max-width: 1200px; padding: 0px 15px; margin: 30px auto;">

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

			<header class="entry-header">

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				
				<?php
				if( class_exists('acf') && get_field('sub_title') )
				{ 
					echo '<h2 class="sub-title">';
					echo do_shortcode( get_field('sub_title') );
					echo '</h2>';
				} 
				?>

				<div class="entry-meta">
					<small>
					<?php
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

						echo custom_taxonomy_terms( $post->ID, 'location' );
						echo ' | ';
					    echo custom_taxonomy_terms( $post->ID, 'type' );
					?>
					</small>
				</div>

			</header><!-- .entry-header -->

			<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

			<div class="entry-content">
				<?php 
				if( class_exists('acf') ) {
					$image = get_field('image');
					if( !empty( $image ) ): ?>
					    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					<?php endif;
				} ?>
			</div><!-- .entry-content -->

		</article><!-- #post-## -->

	<?php if ( current_user_can('editor') || current_user_can('administrator') ): ?>

		<div style="margin-bottom: 40px;"></div>

		<?php acf_form_head(); ?>
		<?php get_header(); ?>

			<div id="primary" style="padding: 15px; border: 1px solid gray;">
				<div id="content" role="main">

					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						
						<h2>Edit Estate Information</h2>
						
						<?php acf_form(array(
							'post_title'	=> true,
							'fields' => array(
								'field_1',
							),
							'submit_value'	=> 'Update the post!'
						));
						?>

					<?php endwhile; ?>

				</div><!-- #content -->
			</div><!-- #primary -->

		<?php get_footer(); ?>

		<!--// edit Post Form -->

	<?php endif; ?>

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
