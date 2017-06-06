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
    <div class="post__content">
        <header class="entry-header">
            <?php amp_the_category_list(); ?>
            <?php
            if ( is_single() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;

            if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php amp_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php
            endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->
        <div class="continue-reading">
            <?php
            $continue_reading_link = sprintf(
                /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s...', 'amp' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
            );
            ?>
            <a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">
                <?php echo $continue_reading_link; ?>
            </a>
        </div> <!-- continue-reading -->
    </div> <!-- post__content -->
</article><!-- #post-## -->
