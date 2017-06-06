<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AMP_Compatible_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php amp_the_category_list(); ?>
        <?php
        $build_mode = get_theme_mod( 'markup');
        $before = '<h1 class="entry-title"><span style="color:red">Generating ' . $build_mode . ' HTML</span>';
		if ( is_single() ) :
			the_title( $before, '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="entry-meta">
			<?php amp_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

    <section class="post-content">
        <?php
        if ( ! is_active_sidebar( 'sidebar-1' ) ) : ?>
            <div class="post-content__wrap">
                <div class="entry-meta">
                    <?php amp_posted_on(); ?>
                </div><!-- .entry-meta -->
                <div class="post-content__body">
	    <?php endif; ?>

        <div class="entry-content">
		    <?php
		    the_content( sprintf(
		    /* translators: %s: Name of current post. */
			    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'amp' ), array( 'span' => array( 'class' => array() ) ) ),
			    the_title( '<span class="screen-reader-text">"', '"</span>', false )
		    ) );

		    wp_link_pages( array(
			    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'amp' ),
			    'after'  => '</div>',
		    ) );
		    ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php amp_entry_footer(); ?>
        </footer><!-- .entry-footer -->

        <?php
        if ( ! is_active_sidebar( 'sidebar-1' ) ) : ?>
                </div> <!-- post-content__body -->
            </div> <!-- post-content__wrap -->
        <?php endif; ?>
        <?php
        amp_post_navigation();
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
        comments_template();
        endif;
        ?>
    </section> <!-- post-content -->
    <?php get_sidebar(); ?>
</article><!-- #post-## -->
