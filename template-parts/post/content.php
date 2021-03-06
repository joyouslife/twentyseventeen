<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( is_sticky() && is_home() ) :
		echo twentyseventeen_get_svg( array( 'icon' => 'thumb-tack' ) );
	endif;
	?>
	<header class="entry-header">
		<?php
		if ( 'post' === get_post_type() ) {
			echo '<div class="entry-meta">';
				if ( is_single() ) {
					twentyseventeen_posted_on();
				} else {
					echo twentyseventeen_time_link();
					twentyseventeen_edit_link();
				};
			echo '</div><!-- .entry-meta -->';
		};


		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif ( is_front_page() && is_home() ) {
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		if ( 'movie' === get_post_type() ) {
			$mb_data = get_post_meta( $post->ID, '2017_mb' );
			$sub = '';
			if (!empty($mb_data)) {
				$sub = $mb_data[0];
			}
			if (!empty($sub)) {
				echo '<h6>Subtitle: ' . $sub . '</h6>';
			}

			$post_terms = wp_get_object_terms( $post->ID, 'movie-category', array( 'fields' => 'ids' ) );
			if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
				$term_ids = implode( ',' , $post_terms );

				$terms = wp_list_categories( array(
						'title_li' => '',
						'style'    => 'none',
						'echo'     => false,
						'taxonomy' => 'movie-category',
						'include'  => $term_ids
				) );
				$terms = rtrim( trim( str_replace( '<br />',  ', ', $terms ) ), ', ' );
				echo  $terms;
			}?>

			<form action="" method="post">
            <input name="add-to-cart" type="hidden" value="<?php the_ID(); ?>" />
            <input name="quantity" type="number" value="1" min="1"  />
            <input name="submit" type="submit" value="Add to cart" />
      </form>
<?php
			echo sprintf( '<br/><a rel="nofollow" href="%s/?add-to-cart=%s&qb=1" data-quantity="1">%s</a>',
				esc_url( home_url() ),
				esc_attr(  $post->ID ),
				__( 'Quick buy', 'twentyseventeen' ));
		}
		?>
	</header><!-- .entry-header -->

	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php
	if ( is_single() ) {
		twentyseventeen_entry_footer();
	}
	?>

</article><!-- #post-## -->
